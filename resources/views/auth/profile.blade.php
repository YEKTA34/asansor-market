@extends('layouts.app')

@section('title', 'Profil Ayarlarım')

@section('content')
<div class="row g-4">
    <!-- Sol Taraf: Profil Güncelleme ve Hesap Dondurma -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
            <h4 class="fw-bold mb-4">
                <i class="fa-solid fa-user-gear text-primary me-2"></i>Profil Ayarları
            </h4>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                <!-- Ad Soyad -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-muted">Ad Soyad / Firma Ünvanı</label>
                    <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- E-posta -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-muted">E-Posta Adresi</label>
                    <input type="email" name="email" id="email" class="form-control shadow-none @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Telefon -->
                <div class="mb-3">
                    <label for="phone" class="form-label small fw-bold text-muted">İletişim Numarası</label>
                    <input type="text" name="phone" id="phone" class="form-control shadow-none @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Adres -->
                <div class="mb-4">
                    <label for="address" class="form-label small fw-bold text-muted">Sevk ve Fatura Adresi</label>
                    <textarea name="address" id="address" rows="3" class="form-control shadow-none @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="p-3 bg-light rounded-3 mb-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-key me-2 text-warning"></i>Şifre Değiştirme</h6>
                    <p class="text-muted small mb-3">Şifrenizi değiştirmek istemiyorsanız aşağıdaki şifre alanlarını boş bırakabilirsiniz.</p>
                    
                    <!-- Mevcut Şifre -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label small fw-bold text-muted">Mevcut Şifre</label>
                        <input type="password" name="current_password" id="current_password" class="form-control shadow-none @error('current_password') is-invalid @enderror" placeholder="••••••">
                        @error('current_password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row g-2">
                        <!-- Yeni Şifre -->
                        <div class="col-md-6 mb-2">
                            <label for="password" class="form-label small fw-bold text-muted">Yeni Şifre</label>
                            <input type="password" name="password" id="password" class="form-control shadow-none @error('password') is-invalid @enderror" placeholder="En az 6 haneli">
                            @error('password')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Yeni Şifre Tekrar -->
                        <div class="col-md-6 mb-2">
                            <label for="password_confirmation" class="form-label small fw-bold text-muted">Yeni Şifre Tekrarı</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-none" placeholder="Yeniden girin">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-premium-primary w-100 py-2 rounded-3">
                    Profil Bilgilerini Kaydet <i class="fa-solid fa-floppy-disk ms-2"></i>
                </button>
            </form>

            <hr class="opacity-10 my-5">

            <!-- Üyelik Dondurma Butonu -->
            <div class="bg-danger-subtle p-4 rounded-3 border-0">
                <h6 class="fw-bold text-danger mb-2">
                    <i class="fa-solid fa-user-slash me-2"></i>Üyeliği Dondur (Pasif Üyelik)
                </h6>
                <p class="text-danger-emphasis small mb-3">
                    Hesabınızı dondurduğunuzda profiliniz ve hediye bakiyeleriniz korunur fakat sisteme tekrar giriş yapamazsınız. Yeniden aktif etmek için sistem yöneticinizle irtibata geçmeniz gerekecektir.
                </p>
                <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                    Hesabımı Pasifleştir / Dondur
                </button>
            </div>
        </div>
    </div>

    <!-- Sağ Taraf: Hediye Bakiye Durumu ve İşlem Geçmişi -->
    <div class="col-lg-5">
        <!-- Bakiye Kartı -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 mb-4 text-center">
            <h5 class="fw-bold text-muted mb-2">Hediye Bakiyeniz</h5>
            <span class="d-block display-5 fw-extrabold text-success mb-2 font-monospace">₺{{ number_format($user->balance, 2, ',', '.') }}</span>
            <p class="small text-muted mb-0">
                Sipariş iptallerinde iadeler bu bakiyeye hediye olarak aktarılır. Alışveriş yaparken öncelikle bu bakiye kullanılır.
            </p>
        </div>

        <!-- İşlem Geçmişi -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <h5 class="fw-bold mb-4">
                <i class="fa-solid fa-receipt text-primary me-2"></i>Bakiye Hareketleri
            </h5>
            
            @php
                $transactions = \App\Models\BalanceTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            @endphp

            @if($transactions->isEmpty())
                <div class="text-center py-4">
                    <i class="fa-solid fa-folder-open text-muted display-6 mb-3 opacity-50"></i>
                    <span class="d-block text-muted small">Herhangi bir bakiye hareketi bulunmuyor.</span>
                </div>
            @else
                <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    @foreach($transactions as $tx)
                        <div class="list-group-item px-0 py-3 border-bottom bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge {{ $tx->type === 'refund' ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded">
                                    {{ $tx->type === 'refund' ? 'İade Alındı' : 'Harcama' }}
                                </span>
                                <span class="small font-monospace {{ $tx->amount > 0 ? 'text-success' : 'text-danger' }} fw-bold" style="font-size: 1.05rem;">
                                    {{ $tx->amount > 0 ? '+' : '' }}₺{{ number_format($tx->amount, 2, ',', '.') }}
                                </span>
                            </div>
                            <span class="d-block small text-dark fw-semibold">{{ $tx->description }}</span>
                            <span class="d-block text-muted" style="font-size: 0.75rem;">{{ $tx->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Üyelik Dondurma Onay Modalı -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-danger text-white p-4">
                <h5 class="modal-title fw-bold" id="deactivateModalLabel">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Emin misiniz?
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fa-solid fa-circle-exclamation text-danger display-4 mb-3"></i>
                <p class="fw-semibold text-dark mb-2">Hesabınızı dondurmak üzeresiniz!</p>
                <p class="text-muted small">
                    Bu işlem sonucunda mevcut oturumunuz kapatılacak ve yönetici hesabı tekrar aktif edene kadar sisteme giriş yapamayacaksınız. Bu işlemi onaylıyor musunuz?
                </p>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4 rounded-pill btn-sm" data-bs-dismiss="modal">Vazgeç</button>
                <form action="{{ route('profile.deactivate') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4 rounded-pill btn-sm fw-bold">Evet, Hesabımı Dondur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
