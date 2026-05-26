@extends('layouts.app')

@section('title', 'Giriş Yap')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <!-- Üst Başlık Şeridi -->
            <div class="bg-dark text-white p-4 text-center">
                <i class="fa-solid fa-elevator text-primary display-4 mb-2"></i>
                <h4 class="fw-bold mb-0">LiftMarket Oturum Aç</h4>
                <p class="text-muted small mb-0 mt-1">Asansör teknik yedek parça sipariş yönetim portalı</p>
            </div>
            
            <!-- Giriş Formu -->
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- E-posta -->
                    <div class="mb-4">
                        <label for="email" class="form-label small fw-bold text-muted">E-Posta Adresiniz</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control bg-light border-start-0 shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="isim@domain.com" required autofocus>
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Şifre -->
                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-muted">Giriş Şifreniz</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control bg-light border-start-0 shadow-none @error('password') is-invalid @enderror" placeholder="••••••" required>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Giriş Yap Butonu -->
                    <button type="submit" class="btn btn-premium-primary w-100 py-2 fs-6 rounded-3 mt-2">
                        Giriş Yap <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                    </button>
                </form>
            </div>

            <!-- Kayıt Ol Yönlendirmesi -->
            <div class="card-footer bg-light p-4 text-center border-0">
                <span class="text-muted small">Henüz üye değil misiniz?</span>
                <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none small ms-2">Hemen Kayıt Olun</a>
            </div>
        </div>
    </div>
</div>
@endsection
