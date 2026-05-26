<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $cartItems = Cart::with('product')
                         ->where('user_id', $userId)
                         ->get();

        $totalPrice = 0.00;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $totalPrice += $item->product->price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Maalesef bu üründen stokta yeterli miktar bulunmuyor. Mevcut Stok: ' . $product->stock);
        }

        $existingCartItem = Cart::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $quantity;

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Sepetinizdeki miktar ile eklemek istediğiniz miktar toplamı stok sınırını aşıyor! Mevcut Stok: ' . $product->stock);
            }

            $existingCartItem->quantity = $newQuantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Ürün başarıyla sepetinize eklendi.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($id);
        
        if ($cartItem->user_id !== Auth::id()) {
            return back()->with('error', 'Yetkisiz işlem.');
        }

        $product = Product::findOrFail($cartItem->product_id);
        $newQuantity = $request->input('quantity');

        if ($product->stock < $newQuantity) {
            return back()->with('error', 'İstediğiniz adet stok limitini aşıyor! Mevcut Stok: ' . $product->stock);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Sepet güncellendi.');
    }

    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->user_id !== Auth::id()) {
            return back()->with('error', 'Yetkisiz işlem.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Ürün sepetinizden kaldırıldı.');
    }
}
