@extends('layouts.app')

@section('title', $product->name . ' Detayları')

@section('content')
<div class="row g-5">
    <!-- Ürün Görseli -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white text-center p-3 d-flex align-items-center justify-content-center" style="min-height: 400px;">
            @if($product->image_path)
                <img src="{{ asset($product->image_path) }}" class="img-fluid rounded-3 object-fit-contain" style="max-height: 450px;" alt="{{ $product->name }}">
            @else
                <div class="text-muted my-5">
                    <i class="fa-solid fa-elevator display-1 opacity-25"></i>
                    <span class="d-block mt-3">Bu ürüne ait görsel bulunmamaktadır.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Ürün Bilgileri ve Sepete Ekleme -->
    <div class="col-lg-6">
        <div class="ps-lg-3">
            <span class="badge bg-primary px-3 py-2 rounded-pill font-monospace mb-3">{{ $product->category }}</span>
            <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="fs-2 fw-bold text-primary">₺{{ number_format($product->price, 2, ',', '.') }}</span>
                
                <!-- Stok Durumu -->
                @if($product->stock > 5)
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                        <i class="fa-solid fa-check-circle me-1"></i> Stokta Var ({{ $product->stock }} adet)
                    </span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-semibold">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Kritik Stok (Son {{ $product->stock }} adet!)
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">
                        <i class="fa-solid fa-circle-xmark me-1"></i> Tükendi
                    </span>
                @endif
            </div>

            <hr class="opacity-10 my-4">

            <!-- Ürün Açıklaması -->
            <h5 class="fw-bold mb-3 text-dark">Ürün Açıklaması</h5>
            <p class="text-muted leading-relaxed mb-4">
                {{ $product->description ?: 'Bu teknik parça için detaylı bir açıklama girilmemiştir.' }}
            </p>

            <hr class="opacity-10 my-4">

            <!-- Sepete Ekleme Formu -->
            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="row g-3 align-items-center">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Miktar</label>
                        <input type="number" name="quantity" class="form-control text-center shadow-none fw-bold" value="1" min="1" max="{{ $product->stock }}">
                    </div>
                    
                    <div class="col-md-9 pt-md-4">
                        <button type="submit" class="btn btn-premium-primary w-100 py-2 fs-6 rounded-3">
                            <i class="fa-solid fa-cart-plus me-2"></i> Sepete Ekle
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-secondary border-0 p-3 rounded-3 d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-circle-info fs-4 me-3 text-muted"></i>
                    <div class="small fw-semibold">
                        Bu ürünün stokları geçici olarak tükenmiştir. Yeni stoklar eklendiğinde tekrar sipariş verebilirsiniz.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Benzer Ürünler -->
@if(!$relatedProducts->isEmpty())
    <div class="mt-5 pt-5 border-top">
        <h4 class="fw-bold mb-4">
            <i class="fa-solid fa-share-nodes text-primary me-2"></i>Benzer Ürünler
        </h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-md-3 col-6">
                    <div class="card h-100 card-premium">
                        <div class="bg-light text-center d-flex align-items-center justify-content-center" style="height: 150px; overflow:hidden;">
                            @if($related->image_path)
                                <img src="{{ asset($related->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $related->name }}">
                            @else
                                <i class="fa-solid fa-elevator display-5 opacity-25"></i>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $related->name }}</h6>
                            <span class="text-primary fw-bold small">₺{{ number_format($related->price, 2, ',', '.') }}</span>
                            <a href="{{ route('products.show', $related->id) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
