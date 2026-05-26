@extends('layouts.app')

@section('title', 'Alışveriş Sepetim')

@section('content')
<div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
    <h3 class="fw-bold mb-4">
        <i class="fa-solid fa-cart-shopping text-primary me-2"></i>Alışveriş Sepetim
    </h3>

    @if($cartItems->isEmpty())
        <!-- Boş Sepet Görünümü -->
        <div class="text-center py-5">
            <i class="fa-solid fa-cart-plus text-muted display-1 mb-4 opacity-50"></i>
            <h4 class="fw-bold text-dark">Sepetiniz şu anda boş!</h4>
            <p class="text-muted mb-4">Asansör teknik parça kataloğumuzu inceleyerek ihtiyacınız olan ekipmanları hemen sepetinize ekleyebilirsiniz.</p>
            <a href="{{ route('home') }}" class="btn btn-premium-primary px-4 rounded-pill">
                <i class="fa-solid fa-layer-group me-2"></i> Ürün Kataloğuna Git
            </a>
        </div>
    @else
        <!-- Sepette Ürün Varsa Tablo -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold border-bottom">
                        <th scope="col" style="width: 100px;">Görsel</th>
                        <th scope="col">Ürün Bilgisi</th>
                        <th scope="col" class="text-center" style="width: 150px;">Birim Fiyat</th>
                        <th scope="col" class="text-center" style="width: 180px;">Miktar (Adet)</th>
                        <th scope="col" class="text-center" style="width: 150px;">Toplam Tutar</th>
                        <th scope="col" class="text-end" style="width: 80px;">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        @if($item->product)
                            <tr class="border-bottom">
                                <!-- Ürün Resmi -->
                                <td>
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center overflow-hidden" style="width: 70px; height: 70px;">
                                        @if($item->product->image_path)
                                            <img src="{{ asset($item->product->image_path) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $item->product->name }}">
                                        @else
                                            <i class="fa-solid fa-elevator text-muted display-6 opacity-30"></i>
                                        @endif
                                    </div>
                                </td>

                                <!-- Ürün Adı ve Kategori -->
                                <td>
                                    <h6 class="fw-bold mb-1 text-dark">{{ $item->product->name }}</h6>
                                    <span class="badge bg-light text-secondary font-monospace" style="font-size: 0.75rem;">{{ $item->product->category }}</span>
                                    
                                    <!-- Stok Uyarısı -->
                                    <span class="d-block small text-muted mt-1">Mevcut Stok: <strong>{{ $item->product->stock }} adet</strong></span>
                                </td>

                                <!-- Birim Fiyat -->
                                <td class="text-center fw-semibold">
                                    ₺{{ number_format($item->product->price, 2, ',', '.') }}
                                </td>

                                <!-- Adet Güncelleme -->
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-1 justify-content-center">
                                        @csrf
                                        <input type="number" name="quantity" class="form-control text-center shadow-none form-control-sm fw-bold" style="width: 70px;" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                        <button type="submit" class="btn btn-outline-primary btn-sm rounded" title="Güncelle">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                        </button>
                                    </form>
                                </td>

                                <!-- Satır Toplamı -->
                                <td class="text-center fw-bold text-primary">
                                    ₺{{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                </td>

                                <!-- Sepetten Sil -->
                                <td class="text-end">
                                    <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-outline-danger btn-sm rounded" onclick="return confirm('Bu ürünü sepetinizden kaldırmak istediğinize emin misiniz?')" title="Sepetten Kaldır">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Alt Toplam ve İşlem Butonları -->
        <div class="row g-4 justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="col-md-6 text-center text-md-start">
                <a href="{{ route('home') }}" class="btn btn-link text-decoration-none fw-semibold p-0">
                    <i class="fa-solid fa-arrow-left-long me-2"></i> Alışverişe Devam Et
                </a>
            </div>
            
            <div class="col-md-5 text-center text-md-end">
                <div class="p-3 bg-light rounded-3 mb-3 d-inline-block text-start w-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Sepet Alt Toplamı:</span>
                        <span class="fw-semibold">₺{{ number_format($totalPrice, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                        <strong class="text-dark">Toplam Ödeme Tutarı:</strong>
                        <strong class="fs-4 text-primary font-monospace">₺{{ number_format($totalPrice, 2, ',', '.') }}</strong>
                    </div>
                </div>
                
                <a href="{{ route('order.checkout') }}" class="btn btn-premium-primary w-100 py-3 fs-6 rounded-3">
                    Ödeme ve Sipariş Adımına Geç <i class="fa-solid fa-credit-card ms-2"></i>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
