<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'LiftMarket') - Asansör Teknik Parça ve Ekipmanları</title>
    
    <!-- Google Fonts (Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom Premium CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-gradient: linear-gradient(135deg, #0f52ba 0%, #007bff 100%);
            --dark-bg: #0f172a;
            --card-border: rgba(255, 255, 255, 0.08);
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Tasarımı */
        .navbar-custom {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand span {
            background: linear-gradient(to right, #38bdf8, #007bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Kart ve Bölüm Tasarımları */
        .card-premium {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.06), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-premium-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
            transition: all 0.2s ease;
        }

        .btn-premium-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.35);
            opacity: 0.95;
            color: white;
        }

        .btn-premium-dark {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-premium-dark:hover {
            background: #1e293b;
            color: white;
            transform: translateY(-2px);
        }

        /* Timeline / Sipariş Süreç Takibi */
        .timeline-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .timeline-steps::before {
            content: "";
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e2e8f0;
            z-index: 1;
        }

        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 15%;
        }

        .timeline-step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e2e8f0;
            border: 4px solid #f8fafc;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .timeline-step.active .timeline-step-icon {
            background: #0d6efd;
            color: white;
            box-shadow: 0 0 0 5px rgba(13, 110, 253, 0.25);
            border-color: #ffffff;
        }

        .timeline-step.completed .timeline-step-icon {
            background: #10b981;
            color: white;
            border-color: #ffffff;
        }

        .timeline-step-label {
            margin-top: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            text-align: center;
        }

        .timeline-step.active .timeline-step-label {
            color: #0d6efd;
        }

        .timeline-step.completed .timeline-step-label {
            color: #10b981;
        }

        /* Premium Footer */
        footer {
            margin-top: auto;
            background: #0b0f19;
            color: #94a3b8;
            padding: 60px 0 25px 0;
            border-top: 1px solid rgba(56, 189, 248, 0.15);
            font-size: 0.9rem;
            position: relative;
        }

        footer h5 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 24px;
            font-size: 1.15rem;
            position: relative;
        }

        footer h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 35px;
            height: 3px;
            background: linear-gradient(to right, #38bdf8, #0d6efd);
            border-radius: 2px;
        }

        footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        footer a:hover {
            color: #38bdf8;
            transform: translateX(4px);
        }

        footer .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        footer .social-icon:hover {
            background: #0d6efd;
            border-color: #38bdf8;
            color: white;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.4);
        }

        footer .tech-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Üst Menü / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-elevator text-primary"></i>
                <span>LiftMarket</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house me-1"></i> Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('products.index') || Route::is('products.show') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fa-solid fa-layer-group me-1"></i> Ürün Kataloğu
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <!-- Oturum Açmış Üye Menüsü -->
                        @if(Auth::user()->isAdmin())
                            <!-- Admin Özel Paneli Linki -->
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning btn-sm px-3 rounded-pill fw-semibold">
                                <i class="fa-solid fa-screwdriver-wrench me-1"></i> Yönetici Paneli
                            </a>
                        @endif

                        <!-- Sepet Sayacı -->
                        <a href="{{ route('cart.index') }}" class="btn btn-premium-dark btn-sm px-3 position-relative rounded-pill">
                            <i class="fa-solid fa-cart-shopping me-1"></i> Sepetim
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-dark" style="font-size: 0.75rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Kullanıcı Açılır Menü -->
                        <div class="dropdown">
                            <a class="btn btn-premium-primary btn-sm px-3 dropdown-toggle rounded-pill" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" aria-labelledby="userDropdown">
                                <li>
                                    <div class="px-3 py-2 border-bottom">
                                        <span class="d-block text-muted small">Mevcut Bakiye</span>
                                        <strong class="text-success" style="font-size: 1.1rem;">₺{{ number_format(Auth::user()->balance, 2, ',', '.') }}</strong>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile') }}">
                                        <i class="fa-solid fa-user-gear me-2 text-muted"></i> Profil Ayarlarım
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('orders.index') }}">
                                        <i class="fa-solid fa-box-open me-2 text-muted"></i> Sipariş Takibi
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Güvenli Çıkış
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Giriş Yapmamış Ziyaretçi Linkleri -->
                        <a href="{{ route('login') }}" class="nav-link py-2 px-3">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Giriş Yap
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-premium-primary btn-sm px-4 rounded-pill">
                            <i class="fa-solid fa-user-plus me-1"></i> Kayıt Ol
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Ana İçerik Alanı -->
    <main class="container my-5">
        
        <!-- Bildirim Mesajları (Flash Message Controller) -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 p-3 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 p-3 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-4 me-3 text-danger"></i>
                <div>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 p-3" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <strong class="fs-6">Lütfen form hatalarını düzeltin:</strong>
                </div>
                <ul class="mb-0 ps-5 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Sayfa Alt Bilgisi / Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-3 text-white">
                        <i class="fa-solid fa-elevator text-primary me-2"></i>LiftMarket
                    </h5>
                    <p class="small text-muted mb-4 mt-3">
                        Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği TBL304 Web Programlama dersi kapsamında geliştirilmiş, İçerik Yönetim Sistemine (CMS) sahip asansör yedek parça ve teknik ekipman e-ticaret portalıdır.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3 text-white">Hızlı Menü</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mt-3" style="padding-left: 0;">
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right me-1 small" style="font-size: 0.7rem;"></i> Ana Sayfa</a></li>
                        <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-chevron-right me-1 small" style="font-size: 0.7rem;"></i> Ürün Kataloğu</a></li>
                        <li><a href="{{ route('cart.index') }}"><i class="fa-solid fa-chevron-right me-1 small" style="font-size: 0.7rem;"></i> Sepetim</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}"><i class="fa-solid fa-chevron-right me-1 small" style="font-size: 0.7rem;"></i> Sipariş Takip</a></li>
                        @else
                            <li><a href="{{ route('login') }}"><i class="fa-solid fa-chevron-right me-1 small" style="font-size: 0.7rem;"></i> Giriş Yap</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3 text-white">Proje Altyapısı</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mt-3" style="padding-left: 0;">
                        <li class="text-muted"><i class="fa-solid fa-code text-primary me-2"></i><strong>Framework:</strong> Laravel 11 MVC</li>
                        <li class="text-muted"><i class="fa-solid fa-database text-primary me-2"></i><strong>Database:</strong> MySQL Engine</li>
                        <li class="text-muted"><i class="fa-solid fa-palette text-primary me-2"></i><strong>Arayüz:</strong> Bootstrap 5 & HSL</li>
                        <li class="text-muted"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i><strong>Entegrasyon:</strong> Weather & Currency API</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3 text-white">Ders Bilgileri</h5>
                    <p class="small text-muted mb-3 mt-3">
                        Kocaeli Üniversitesi Teknoloji Fakültesi Bilişim Sistemleri Mühendisliği Bölümü Bahar Dönemi Projesidir.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="tech-badge"><i class="fa-solid fa-graduation-cap text-primary me-1"></i> TBL304</span>
                        <span class="tech-badge"><i class="fa-solid fa-desktop text-primary me-1"></i> Web Prog.</span>
                        <span class="tech-badge"><i class="fa-solid fa-user-graduate text-primary me-1"></i> Öğrenci Projesi</span>
                    </div>
                </div>
            </div>
            <div class="pt-4 border-top border-secondary border-opacity-25 text-center text-muted small d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0">&copy; {{ date('Y') }} LiftMarket. Tüm Hakları Saklıdır. | Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği</p>
                <div class="d-flex gap-3">
                    <span class="text-muted">Geliştirici: Öğrenci Cengiz</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
