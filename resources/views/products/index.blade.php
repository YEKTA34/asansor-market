@extends('layouts.app')

@section('title', 'Asansör Teknik Parça Kataloğu')

@section('content')
<div class="row g-4">
    <!-- Sol Filtreleme Menüsü -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white sticky-lg-top" style="top: 90px; z-index: 10;">
            <h5 class="fw-bold mb-4">
                <i class="fa-solid fa-filter text-primary me-2"></i>Katalog Filtresi
            </h5>
            
            <!-- Arama Formu -->
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <label class="form-label small fw-semibold text-muted mb-2">Kelime Arama</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-end-0 shadow-none" placeholder="Örn: Motor, Halat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary border-start-0 bg-white" type="submit">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </button>
                </div>
                @if(request('search') || request('category'))
                    <a href="{{ route('home') }}" class="btn btn-link text-danger text-decoration-none small p-0 mt-2 d-inline-block">
                        <i class="fa-solid fa-rotate-left me-1"></i> Filtreleri Temizle
                    </a>
                @endif
            </form>
            
            <!-- Kategoriler -->
            <div>
                <label class="form-label small fw-semibold text-muted mb-3">Kategoriler</label>
                <div class="list-group list-group-flush">
                    <a href="{{ route('products.index', ['search' => request('search')]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-0 bg-transparent py-2 fw-medium {{ !request('category') ? 'text-primary' : 'text-dark' }}">
                        <span>Tüm Ürünler</span>
                        <i class="fa-solid fa-chevron-right small"></i>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category, 'search' => request('search')]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-0 bg-transparent py-2 fw-medium {{ request('category') === $category ? 'text-primary' : 'text-dark' }}">
                            <span>{{ $category }}</span>
                            <i class="fa-solid fa-chevron-right small"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Ürün Listesi -->
    <div class="col-lg-9">
        <!-- Başlık ve Filtre Özeti -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    @if(request('category'))
                        {{ request('category') }} Ekipmanları
                    @elseif(request('search'))
                        "{{ request('search') }}" Arama Sonuçları
                    @else
                        Güvenilir Asansör Ekipmanları
                    @endif
                </h3>
                <span class="text-muted small">Toplam {{ $products->count() }} parça görüntülendi.</span>
            </div>
        </div>

        @if($products->isEmpty())
            <!-- Ürün Bulunamadı -->
            <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white my-4">
                <i class="fa-solid fa-box-open text-muted display-1 mb-4"></i>
                <h4 class="fw-bold">Aradığınız kriterlere uygun ürün bulunamadı.</h4>
                <p class="text-muted mb-4">Lütfen farklı kelimelerle arama yapmayı veya kategori değiştirmeyi deneyin.</p>
                <a href="{{ route('home') }}" class="btn btn-premium-primary rounded-pill px-4">Tüm Kataloğu Göster</a>
            </div>
        @else
            <!-- Ürünler Izgarası (Grid) -->
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 card-premium">
                            <!-- Ürün Fotoğrafı -->
                            <div class="position-relative bg-light text-center d-flex align-items-center justify-content-center" style="height: 220px; overflow:hidden;">
                                @if($product->image_path)
                                    <img src="{{ asset($product->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                @else
                                    <div class="text-muted">
                                        <i class="fa-solid fa-elevator display-3 mb-2 opacity-50"></i>
                                        <span class="d-block small">Görsel Mevcut Değil</span>
                                    </div>
                                @endif
                                
                                <!-- Kategori Etiketi -->
                                <span class="position-absolute top-3 start-3 badge bg-dark opacity-90 px-3 py-2 rounded-pill font-monospace" style="font-size: 0.7rem; top: 12px; left: 12px;">
                                    {{ $product->category }}
                                </span>

                                <!-- Stok Sınır Uyarısı -->
                                @if($product->stock == 0)
                                    <span class="position-absolute badge bg-danger px-3 py-2 rounded-pill fw-bold" style="top: 12px; right: 12px; font-size: 0.7rem;">
                                        Tükendi
                                    </span>
                                @elseif($product->stock <= 3)
                                    <span class="position-absolute badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="top: 12px; right: 12px; font-size: 0.7rem;">
                                        Son {{ $product->stock }} Ürün!
                                    </span>
                                @endif
                            </div>

                            <!-- Ürün Detayları -->
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-2 text-dark">{{ $product->name }}</h5>
                                <p class="card-text text-muted small mb-4 flex-grow-1">
                                    {{ Str::limit($product->description, 75, '...') }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                                        <span class="d-block text-muted small">Birim Fiyatı</span>
                                        <span class="fw-bold fs-5 text-primary">₺{{ number_format($product->price, 2, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-premium-dark btn-sm px-3 rounded-pill">
                                        Detaylar <i class="fa-solid fa-circle-info ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
