<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\BalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş olduğu için ödeme sayfasına gidemezsiniz.');
        }

        $totalPrice = 0.00;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $totalPrice += $item->product->price * $item->quantity;
            }
        }

        $user = Auth::user();
        
        $balanceUsed = 0.00;
        $cardAmount = 0.00;

        if ($user->balance > 0) {
            if ($user->balance >= $totalPrice) {
                $balanceUsed = $totalPrice;
                $cardAmount = 0.00;
            } else {
                $balanceUsed = $user->balance;
                $cardAmount = $totalPrice - $user->balance;
            }
        } else {
            $balanceUsed = 0.00;
            $cardAmount = $totalPrice;
        }

        return view('order.checkout', compact('cartItems', 'totalPrice', 'user', 'balanceUsed', 'cardAmount'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'card_name' => 'required_if:card_amount_hidden,>0|string|nullable',
            'card_number' => 'required_if:card_amount_hidden,>0|string|nullable',
            'card_expiry' => 'required_if:card_amount_hidden,>0|string|nullable',
            'card_cvc' => 'required_if:card_amount_hidden,>0|string|nullable',
        ], [
            'shipping_address.required' => 'Teslimat adresi girilmesi zorunludur.',
            'phone.required' => 'İletişim numarası girilmesi zorunludur.',
            'card_name.required_if' => 'Kart sahibinin adı girilmelidir.',
            'card_number.required_if' => 'Kart numarası girilmelidir.',
            'card_expiry.required_if' => 'Son kullanma tarihi girilmelidir.',
            'card_cvc.required_if' => 'CVC kodu girilmelidir.',
        ]);

        $user = User::findOrFail(Auth::id());
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        $totalPrice = 0.00;
        foreach ($cartItems as $item) {
            if (!$item->product || !$item->product->is_on_sale) {
                return redirect()->route('cart.index')->with('error', 'Sepetinizdeki bazı ürünler artık satışta değil.');
            }
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', $item->product->name . ' ürünü için yeterli stok kalmadı! Stok: ' . $item->product->stock);
            }
            $totalPrice += $item->product->price * $item->quantity;
        }

        $balanceUsed = 0.00;
        $cardPaidAmount = 0.00;

        if ($user->balance > 0) {
            if ($user->balance >= $totalPrice) {
                $balanceUsed = $totalPrice;
                $cardPaidAmount = 0.00;
            } else {
                $balanceUsed = $user->balance;
                $cardPaidAmount = $totalPrice - $user->balance;
            }
        } else {
            $balanceUsed = 0.00;
            $cardPaidAmount = $totalPrice;
        }

        $orderNumber = 'LIFT-' . date('YmdHis') . rand(10, 99);

        DB::beginTransaction();
        try {
            if ($balanceUsed > 0) {
                $user->balance -= $balanceUsed;
                $user->save();

                BalanceTransaction::create([
                    'user_id' => $user->id,
                    'amount' => -$balanceUsed,
                    'type' => 'purchase',
                    'description' => $orderNumber . ' nolu sipariş için bakiye ödemesi yapıldı.',
                ]);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total_price' => $totalPrice,
                'payment_method' => ($balanceUsed > 0 && $cardPaidAmount > 0) ? 'mix' : ($balanceUsed > 0 ? 'balance' : 'credit_card'),
                'shipping_address' => $request->shipping_address,
                'status' => 'pending',
                'balance_used' => $balanceUsed,
                'card_paid_amount' => $cardPaidAmount,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Siparişiniz başarıyla alındı! Yönetici onayından sonra süreciniz başlayacaktır.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sipariş oluşturulurken beklenmedik bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'Yetkisiz erişim.');
        }

        return view('order.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Yetkisiz işlem.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Yönetici siparişinizi onayladığı veya süreci başlattığı için artık siparişi iptal edemezsiniz.');
        }

        DB::beginTransaction();
        try {
            $order->status = 'cancelled';
            $order->save();

            $user = User::findOrFail($order->user_id);
            $user->balance += $order->total_price;
            $user->save();

            BalanceTransaction::create([
                'user_id' => $user->id,
                'amount' => $order->total_price,
                'type' => 'refund',
                'description' => $order->order_number . ' nolu iptal edilen sipariş için iade bakiyesi yüklendi.',
            ]);

            foreach ($order->items as $item) {
                if ($item->product) {
                    $product = $item->product;
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Siparişiniz başarıyla iptal edilmiş ve toplam ödeme tutarı hediye bakiye olarak hesabınıza aktarılmıştır.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'İptal işlemi gerçekleştirilirken hata oluştu: ' . $e->getMessage());
        }
    }

    public function confirmDelivery($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Yetkisiz işlem.');
        }

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Sipariş henüz teslim aşamasına gelmediği için teslim aldı onayını veremezsiniz.');
        }

        $order->status = 'completed';
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Siparişi başarıyla teslim aldığınızı onayladınız. Bizi tercih ettiğiniz için teşekkür ederiz!');
    }
}
