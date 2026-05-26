@extends('layouts.app')

@section('title', 'Geleceğin Asansör Teknolojileri')

@section('styles')
<style>
    /* Futuristic Hero Styles */
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(1deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    .hero-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 28px;
        padding: 80px 60px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.5);
        margin-bottom: 60px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .hero-section::after {
        content: "";
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(13, 110, 253, 0) 70%);
        top: -100px;
        right: -100px;
        pointer-events: none;
    }

    .hero-image-container {
        position: relative;
        animation: float 6s ease-in-out infinite;
        z-index: 2;
    }

    .hero-image-card {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 25px 50px -12px rgba(56, 189, 248, 0.25);
        overflow: hidden;
        transition: all 0.4s ease;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
    }

    .hero-image-card:hover {
        box-shadow: 0 35px 60px -10px rgba(56, 189, 248, 0.45);
        border-color: rgba(56, 189, 248, 0.35);
        transform: scale(1.01);
    }

    .hero-glow {
        position: absolute;
        width: 150%;
        height: 150%;
        top: -25%;
        left: -25%;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(13, 110, 253, 0) 60%);
        pointer-events: none;
        z-index: 0;
    }

    .hero-badge {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #38bdf8;
        padding: 8px 16px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -1px;
        margin-bottom: 20px;
    }

    .hero-title span {
        background: linear-gradient(to right, #38bdf8, #0ea5e9, #0d6efd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-desc {
        font-size: 1.15rem;
        color: #94a3b8;
        max-width: 600px;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    /* İnce Çizgili Premium Kartlar (Glassmorphic) */
    .feature-card {
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        padding: 30px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.05);
        border-color: rgba(13, 110, 253, 0.2);
    }

    .feature-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: rgba(13, 110, 253, 0.06);
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon-wrapper {
        background: #0d6efd;
        color: white;
        transform: rotate(5deg) scale(1.05);
    }

    /* İstatistik Bölümü */
    .stats-container {
        background: #f1f5f9;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 60px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 5px;
    }

    /* Öne Çıkan Ürünler */
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin-bottom: 12px;
    }

    @media (max-width: 991.98px) {
        .hero-section {
            padding: 50px 30px;
            text-align: center;
        }
        .hero-title {
            font-size: 2.5rem;
        }
        .hero-desc {
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>
@endsection

@section('content')
<!-- 1. Hero Karşılama Alanı -->
<div class="hero-section">
    <div class="row align-items-center g-5">
        <div class="col-lg-7">
            <span class="hero-badge">
                <i class="fa-solid fa-graduation-cap text-primary"></i> TBL304 Web Projesi - LiftMarket
            </span>
            <h1 class="hero-title">
                Geleceğin Güvenli <span>Asansör Teknolojileri</span> Burada!
            </h1>
            <p class="hero-desc">
                Türkiye'nin en donanımlı asansör yedek parça, motor ve kumanda sistemleri portalına hoş geldiniz. 
                Lokal bakiye bölüştürme algoritması, harici API destekleri ve gelişmiş sipariş zaman tüneli ile kesintisiz dijital alışveriş deneyimi.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                <a href="{{ route('products.index') }}" class="btn btn-premium-primary btn-lg px-4 rounded-pill">
                    Kataloğu Keşfet <i class="fa-solid fa-arrow-right-long ms-2"></i>
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-premium-dark btn-lg px-4 rounded-pill">
                        Hemen Üye Ol <i class="fa-solid fa-user-plus ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('orders.index') }}" class="btn btn-premium-dark btn-lg px-4 rounded-pill">
                        Siparişlerimi Takip Et <i class="fa-solid fa-box-open ms-2"></i>
                    </a>
                @endguest
            </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-center position-relative">
            <div class="hero-image-container">
                <div class="hero-glow"></div>
                <div class="hero-image-card position-relative z-1" style="border-radius: 24px; overflow: hidden;">
                    <img src="{{ asset('uploads/futuristic_elevator.png') }}" class="img-fluid w-100 object-fit-cover" alt="Futuristic Elevator Concept" style="height: 380px;">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-75 backdrop-blur text-start border-top border-white border-opacity-10" style="backdrop-filter: blur(8px);">
                        <span class="badge bg-primary mb-1 rounded-pill"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> 3D Tasarım</span>
                        <h6 class="fw-bold text-white mb-0" style="font-size: 0.9rem;">Akıllı Asansör Konseptimiz</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">Yüksek verimli VVVF motorlar ve entegre sensör ağı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Neden LiftMarket? Özellikler -->
<div class="mb-6">
    <div class="text-center mb-5">
        <h2 class="section-title">Neden LiftMarket Ekipmanları?</h2>
        <p class="text-muted max-width-600 mx-auto">
            Projemizde yer alan tüm teknik altyapı, TBL304 ders kurallarına ve modern e-ticaret gereksinimlerine göre özel olarak kodlanmıştır.
        </p>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Teknoloji & Güvenlik</h5>
                <p class="text-muted small mb-0">
                    Kocaeli Üniversitesi laboratuvar standartlarına uygun, VVVF pano entegrasyonu ve elektromekanik emniyet kilit parçaları.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Esnek Ödeme</h5>
                <p class="text-muted small mb-0">
                    Önce hediye bakiyeyi eriten, kalanını kredi kartından tahsil eden iki kanallı akıllı ödeme altyapısı.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Kolay İade & Stok</h5>
                <p class="text-muted small mb-0">
                    Tek tıkla sipariş iptali, bakiyenin anında iadesi ve ürün stoklarının veri güvenliğiyle eski haline getirilmesi.
                </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-satellite-dish"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Canlı API Desteği</h5>
                <p class="text-muted small mb-0">
                    Uygulama çökmelerini engelleyen 3 saniye korumalı anlık hava durumu ve döviz kurları entegrasyonu.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 3. Teknik İstatistikler Paneli -->
<div class="stats-container text-center my-5">
    <div class="row g-4">
        <div class="col-6 col-md-3">
            <div class="stat-number">20+</div>
            <div class="text-muted small fw-semibold">Teknik Ekipman</div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-number">5+1</div>
            <div class="text-muted small fw-semibold">Gelişmiş Rol Sınıfı</div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-number">₺250</div>
            <div class="text-muted small fw-semibold">Hediye Hoşgeldin Bakiyesi</div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-number">5 Aşama</div>
            <div class="text-muted small fw-semibold">Gelişmiş Sipariş Takibi</div>
        </div>
    </div>
</div>

<!-- 4. Öne Çıkan Bazı Ürünler -->
<div class="my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="section-title">Öne Çıkan Parçalar</h2>
            <p class="text-muted small mb-0">Kataloğumuzda yer alan popüler teknik ekipmanlardan bazıları.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-semibold">
            Tümünü Gör <i class="fa-solid fa-chevron-right ms-1 small"></i>
        </a>
    </div>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
            <div class="col-md-4">
                <div class="card h-100 card-premium">
                    <div class="bg-light text-center d-flex align-items-center justify-content-center position-relative" style="height: 200px; overflow:hidden;">
                        @if($product->image_path)
                            <img src="{{ asset($product->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                        @else
                            <div class="text-muted">
                                <i class="fa-solid fa-elevator display-3 mb-2 opacity-50"></i>
                                <span class="d-block small">Görsel Mevcut Değil</span>
                            </div>
                        @endif
                        <span class="position-absolute top-3 start-3 badge bg-dark opacity-90 px-3 py-2 rounded-pill font-monospace" style="font-size: 0.65rem; top: 12px; left: 12px;">
                            {{ $product->category }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="fw-bold mb-2 text-dark" style="font-size: 1.1rem;">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1">
                            {{ Str::limit($product->description, 70, '...') }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                            <span class="fw-bold text-primary fs-5">₺{{ number_format($product->price, 2, ',', '.') }}</span>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-premium-dark btn-sm px-3 rounded-pill">İncele</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 5. İletişim ve Konum Bölümü -->
<div class="my-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="section-title">Merkezimiz ve İletişim</h2>
        <p class="text-muted max-width-600 mx-auto">
            LiftMarket asansör ekipmanları olarak, İstanbul genel merkezimizden tüm dünyaya kesintisiz teknik destek ve lojistik sağlıyoruz.
        </p>
    </div>
    <div class="row g-4 align-items-center">
        <!-- İletişim Detayları -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100" style="border: 1px solid rgba(0, 0, 0, 0.05) !important;">
                <h4 class="fw-bold text-dark mb-4"><i class="fa-solid fa-headset text-primary me-2"></i> İletişim Bilgileri</h4>
                
                <div class="d-flex align-items-start mb-3 gap-3">
                    <div class="feature-icon-wrapper m-0" style="width: 45px; height: 45px; font-size: 1.1rem; border-radius: 12px; flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Genel Merkez Adresi</h6>
                        <p class="text-muted small mb-0">Atatürk Mahallesi, Ataşehir Bulvarı No:34/A, Ataşehir / İstanbul</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3 gap-3">
                    <div class="feature-icon-wrapper m-0" style="width: 45px; height: 45px; font-size: 1.1rem; border-radius: 12px; flex-shrink: 0;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Müşteri Destek Hattı</h6>
                        <p class="text-muted small mb-0">+90 (216) 555 44 34</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3 gap-3">
                    <div class="feature-icon-wrapper m-0" style="width: 45px; height: 45px; font-size: 1.1rem; border-radius: 12px; flex-shrink: 0;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">E-Posta Adresimiz</h6>
                        <p class="text-muted small mb-0">info@liftmarket.com.tr</p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div class="feature-icon-wrapper m-0" style="width: 45px; height: 45px; font-size: 1.1rem; border-radius: 12px; flex-shrink: 0;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Çalışma Saatlerimiz</h6>
                        <p class="text-muted small mb-0">Pazartesi - Cumartesi: 09:00 - 18:00 (Pazar Kapalı)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Maps Harita -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4" style="border: 1px solid rgba(0, 0, 0, 0.05) !important;">
                <div style="height: 350px; width: 100%;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d192698.2435722396!2d28.872097063467657!3d41.005278010839815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa7040068086b%3A0xe1cc1901344e590c!2zxLBzdGFuYnVs!5e0!3m2!1str!2str!4v1716300000000!5m2!1str!2str" 
                        style="border:0; width: 100%; height: 100%; min-height: 350px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
