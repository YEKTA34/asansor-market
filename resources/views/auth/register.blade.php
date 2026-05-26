@extends('layouts.app')

@section('title', 'Kayıt Ol')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <!-- Üst Başlık Şeridi -->
            <div class="bg-dark text-white p-4 text-center">
                <i class="fa-solid fa-user-plus text-primary display-4 mb-2"></i>
                <h4 class="fw-bold mb-0">LiftMarket Hesabı Oluştur</h4>
                <p class="text-muted small mb-0 mt-1">Hemen üye olup hediye bakiyelerle asansör parçası sipariş etmeye başlayın</p>
            </div>
            
            <!-- Kayıt Formu -->
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Ad Soyad -->
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label small fw-bold text-muted">Ad Soyad / Firma Adı</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="name" id="name" class="form-control bg-light border-start-0 shadow-none @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ahmet Yılmaz" required>
                            </div>
                            @error('name')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- E-posta -->
                        <div class="col-md-6 mb-2">
                            <label for="email" class="form-label small fw-bold text-muted">E-Posta Adresi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control bg-light border-start-0 shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="isim@firma.com" required>
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telefon -->
                        <div class="col-md-12 mb-2">
                            <label for="phone" class="form-label small fw-bold text-muted">İletişim Numarası (Telefon)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="phone" id="phone" class="form-control bg-light border-start-0 shadow-none @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="0555 123 45 67">
                            </div>
                            @error('phone')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Teslimat Adresi -->
                        <div class="col-md-12 mb-2">
                            <label for="address" class="form-label small fw-bold text-muted">Varsayılan Sevk Adresi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="address" id="address" rows="3" class="form-control bg-light border-start-0 shadow-none @error('address') is-invalid @enderror" placeholder="Fatih Mh. Atatürk Cd. No:41 İzmit / Kocaeli">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Şifre -->
                        <div class="col-md-6 mb-2">
                            <label for="password" class="form-label small fw-bold text-muted">Şifreniz</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control bg-light border-start-0 shadow-none @error('password') is-invalid @enderror" placeholder="En az 6 karakter" required>
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Şifre Tekrar -->
                        <div class="col-md-6 mb-2">
                            <label for="password_confirmation" class="form-label small fw-bold text-muted">Şifre Tekrarı</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock-open"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-light border-start-0 shadow-none" placeholder="Şifrenizi tekrar girin" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kayıt Ol Butonu -->
                    <button type="submit" class="btn btn-premium-primary w-100 py-2 fs-6 rounded-3 mt-4">
                        Kayıt Ol ve Oturumu Başlat <i class="fa-solid fa-user-plus ms-2"></i>
                    </button>
                </form>
            </div>

            <!-- Giriş Yap Yönlendirmesi -->
            <div class="card-footer bg-light p-4 text-center border-0">
                <span class="text-muted small">Zaten hesabınız var mı?</span>
                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none small ms-2">Buradan Giriş Yapın</a>
            </div>
        </div>
    </div>
</div>
@endsection
