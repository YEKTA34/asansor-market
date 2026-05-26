<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalOrdersCount = Order::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $totalUsersCount = User::where('role', 'user')->count();
        $totalProductsCount = Product::count();

        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        $weatherData = [
            'temp' => '18.5',
            'desc' => 'Parçalı Bulutlu',
            'icon' => 'cloud-sun',
            'offline' => true
        ];

        try {
            $weatherResponse = Http::withoutVerifying()->timeout(3)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 40.7649,
                'longitude' => 29.9293,
                'current_weather' => true,
                'timezone' => 'Europe/Istanbul'
            ]);

            if ($weatherResponse->successful()) {
                $current = $weatherResponse->json()['current_weather'];
                $temp = $current['temperature'];
                $code = $current['weathercode'];

                $descriptions = [
                    0 => ['Açık', 'sun'],
                    1 => ['Genelde Açık', 'sun'],
                    2 => ['Parçalı Bulutlu', 'cloud-sun'],
                    3 => ['Bulutlu', 'cloud'],
                    45 => ['Sisli', 'cloud-fog'],
                    48 => ['Kırağı Sisli', 'cloud-fog'],
                    51 => ['Çiseleyen Yağmur', 'cloud-drizzle'],
                    53 => ['Orta Şiddette Çiseleyen Yağmur', 'cloud-drizzle'],
                    55 => ['Yoğun Çiseleyen Yağmur', 'cloud-drizzle'],
                    61 => ['Hafif Yağmurlu', 'cloud-rain'],
                    63 => ['Orta Şiddette Yağmurlu', 'cloud-rain'],
                    65 => ['Yoğun Yağmurlu', 'cloud-rain'],
                    71 => ['Hafif Karlı', 'snowflake'],
                    73 => ['Orta Şiddette Karlı', 'snowflake'],
                    75 => ['Yoğun Karlı', 'snowflake'],
                    80 => ['Hafif Sağanak Yağış', 'cloud-showers-heavy'],
                    81 => ['Orta Şiddette Sağanak Yağış', 'cloud-showers-heavy'],
                    82 => ['Şiddetli Sağanak Yağış', 'cloud-showers-heavy'],
                    95 => ['Gök Gürültülü Fırtına', 'cloud-bolt'],
                ];

                $desc = $descriptions[$code] ?? ['Bilinmiyor', 'cloud'];
                
                $weatherData = [
                    'temp' => $temp,
                    'desc' => $desc[0],
                    'icon' => $desc[1],
                    'offline' => false
                ];
            }
        } catch (\Exception $e) {
        }

        $exchangeRates = [
            'usd' => '34.65',
            'eur' => '37.82',
            'offline' => true
        ];

        try {
            $currencyResponse = Http::withoutVerifying()->timeout(3)->get('https://open.er-api.com/v6/latest/USD');
            if ($currencyResponse->successful()) {
                $rates = $currencyResponse->json()['rates'];
                if (isset($rates['TRY']) && isset($rates['EUR'])) {
                    $usdToTry = $rates['TRY'];
                    $eurToTry = $rates['TRY'] / $rates['EUR'];

                    $exchangeRates = [
                        'usd' => number_format($usdToTry, 2, '.', ''),
                        'eur' => number_format($eurToTry, 2, '.', ''),
                        'offline' => false
                    ];
                }
            }
        } catch (\Exception $e) {
        }

        return view('admin.dashboard', compact(
            'totalSales', 
            'totalOrdersCount', 
            'pendingOrdersCount', 
            'totalUsersCount', 
            'totalProductsCount', 
            'recentOrders',
            'weatherData',
            'exchangeRates'
        ));
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_on_sale' => 'nullable|boolean',
        ], [
            'name.required' => 'Ürün adı zorunludur.',
            'category.required' => 'Kategori seçimi zorunludur.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat geçerli bir sayı olmalıdır.',
            'stock.required' => 'Stok miktarı zorunludur.',
            'stock.integer' => 'Stok tam sayı olmalıdır.',
            'image.image' => 'Lütfen geçerli bir görsel dosyası seçin.',
            'image.max' => 'Görsel boyutu en fazla 2 MB olabilir.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/products');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_on_sale' => $request->has('is_on_sale') ? true : false,
        ]);

        return redirect()->route('admin.products')->with('success', 'Ürün başarıyla eklendi.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_on_sale' => 'nullable|boolean',
        ], [
            'name.required' => 'Ürün adı zorunludur.',
            'category.required' => 'Kategori seçimi zorunludur.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat geçerli bir sayı olmalıdır.',
            'stock.required' => 'Stok miktarı zorunludur.',
            'stock.integer' => 'Stok tam sayı olmalıdır.',
            'image.image' => 'Lütfen geçerli bir görsel dosyası seçin.',
        ]);

        $imagePath = $product->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/products');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_on_sale' => $request->has('is_on_sale') ? true : false,
        ]);

        return redirect()->route('admin.products')->with('success', 'Ürün başarıyla güncellendi.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && File::exists(public_path($product->image_path))) {
            File::delete(public_path($product->image_path));
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Ürün başarıyla silindi.');
    }

    public function users()
    {
        $users = User::where('id', '!=', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        $user->is_active = !$user->is_active;
        $user->save();

        $statusMessage = $user->is_active ? 'Kullanıcı hesabı aktifleştirildi.' : 'Kullanıcı hesabı başarıyla donduruldu.';
        return redirect()->route('admin.users')->with('success', $statusMessage);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Kullanıcı hesabı sistemden tamamen silindi.');
    }

    public function orders()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function advanceOrderStatus($id)
    {
        $order = Order::findOrFail($id);
        $currentStatus = $order->status;

        $statusStages = [
            'pending' => 'supplied',
            'supplied' => 'packaged',
            'packaged' => 'shipping',
            'shipping' => 'transit',
            'transit' => 'delivered',
        ];

        if (array_key_exists($currentStatus, $statusStages)) {
            $nextStatus = $statusStages[$currentStatus];
            $order->status = $nextStatus;
            $order->save();

            $turkishStatusNames = [
                'supplied' => 'Tedarik Ediliyor',
                'packaged' => 'Kutulanıyor',
                'shipping' => 'Kargoya Verildi',
                'transit' => 'Yola Çıktı',
                'delivered' => 'Müşteriye Ulaştı (Teslim Edildi)',
            ];

            return redirect()->route('admin.orders.show', $order->id)
                             ->with('success', 'Sipariş başarıyla sonraki aşamaya geçirildi: ' . $turkishStatusNames[$nextStatus]);
        }

        if ($currentStatus === 'delivered') {
            return back()->with('error', 'Sipariş zaten teslim edildi durumunda. Müşterinin "Ürünlerimi Teslim Aldım" onayı vermesi bekleniyor.');
        }

        if ($currentStatus === 'completed') {
            return back()->with('error', 'Bu sipariş müşteri tarafından teslim alınmış ve süreç tamamlanmıştır.');
        }

        if ($currentStatus === 'cancelled') {
            return back()->with('error', 'İptal edilmiş bir siparişin süreci ilerletilemez.');
        }

        return back()->with('error', 'Bilinmeyen sipariş durumu.');
    }
}
