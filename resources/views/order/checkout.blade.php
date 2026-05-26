@extends('layouts.app')

@section('title', 'Ödeme ve Sipariş Onayı')

@section('content')
<div class="row g-4">
    <!-- Sol Taraf: Sipariş Özeti ve Ürünler -->
    <div class="col-lg-5 order-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <h5 class="fw-bold mb-4">
                <i class="fa-solid fa-list-check text-primary me-2"></i>Sipariş Özeti
            </h5>

            <div class="list-group list-group-flush mb-4">
                @foreach($cartItems as $item)
                    @if($item->product)
                        <div class="list-group-item px-0 py-3 border-bottom bg-transparent d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block fw-bold text-dark">{{ $item->product->name }}</span>
                                <span class="text-muted small">{{ $item->quantity }} adet x ₺{{ number_format($item->product->price, 2, ',', '.') }}</span>
                            </div>
                            <span class="fw-bold text-primary font-monospace">₺{{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</span>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Fiyat Detayları -->
            <div class="p-3 bg-light rounded-3 mb-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Ara Toplam:</span>
                    <span class="fw-semibold">₺{{ number_format($totalPrice, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 text-success">
                    <span class="small fw-semibold"><i class="fa-solid fa-gift me-1"></i> Kullanılan Hediye Bakiye:</span>
                    <span class="fw-bold font-monospace">-₺{{ number_format($balanceUsed, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <strong class="text-dark">Kredi Kartından Çekilecek:</strong>
                    <strong class="fs-5 text-primary font-monospace">₺{{ number_format($cardAmount, 2, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Taraf: Fatura & Ödeme Formu -->
    <div class="col-lg-7 order-lg-1">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
            <h4 class="fw-bold mb-4">
                <i class="fa-solid fa-credit-card text-primary me-2"></i>Sevk ve Ödeme Bilgileri
            </h4>

            <form action="{{ route('order.place') }}" method="POST">
                @csrf

                <!-- Gizli Parametreler (Validasyonlar için controller'da kullanılır) -->
                <input type="hidden" name="card_amount_hidden" value="{{ $cardAmount }}">

                <h6 class="fw-bold mb-3 border-bottom pb-2 text-secondary"><i class="fa-solid fa-truck-ramp-box me-2"></i>Sevk Bilgileri</h6>
                
                <!-- Telefon -->
                <div class="mb-3">
                    <label for="phone" class="form-label small fw-bold text-muted">İletişim Numarası (Telefon)</label>
                    <input type="text" name="phone" id="phone" class="form-control shadow-none @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Örn: 0555 123 45 67" required>
                    @error('phone')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Adres -->
                <div class="mb-4">
                    <label for="shipping_address" class="form-label small fw-bold text-muted">Teslim Edilecek Sevk Adresi</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control shadow-none @error('shipping_address') is-invalid @enderror" placeholder="Fatih Mh. Atatürk Cd. No:41 İzmit / Kocaeli" required>{{ old('shipping_address', $user->address) }}</textarea>
                    @error('shipping_address')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <h6 class="fw-bold mb-3 border-bottom pb-2 text-secondary"><i class="fa-solid fa-shield-halved me-2"></i>Ödeme Yöntemi</h6>

                <!-- Hediye Bakiye Gösterimi -->
                <div class="p-3 bg-success-subtle text-success-emphasis rounded-3 border-0 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="d-block small"><i class="fa-solid fa-wallet me-2"></i>Mevcut Hediye Bakiyeniz</strong>
                        <span class="text-muted small">Öncelikle bu bakiyeniz harcanacaktır.</span>
                    </div>
                    <strong class="fs-5 font-monospace">₺{{ number_format($user->balance, 2, ',', '.') }}</strong>
                </div>

                <!-- Kredi Kartı Giriş Alanları -->
                @if($cardAmount > 0)
                    <div class="p-4 bg-light rounded-4 border-0 mb-4 position-relative">
                        <!-- Mock Kredi Kartı Başlığı -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold text-dark small"><i class="fa-solid fa-credit-card me-2 text-primary"></i>Güvenli Kart Ödeme Arayüzü</span>
                            <div class="d-flex gap-2 text-muted">
                                <i class="fa-brands fa-cc-visa fs-4"></i>
                                <i class="fa-brands fa-cc-mastercard fs-4"></i>
                            </div>
                        </div>

                        <!-- Kart Sahibinin Adı -->
                        <div class="mb-3">
                            <label for="card_name" class="form-label small fw-bold text-muted">Kart Sahibinin Adı</label>
                            <input type="text" name="card_name" id="card_name" class="form-control shadow-none @error('card_name') is-invalid @enderror" placeholder="MİTHAT CAN" value="{{ old('card_name') }}">
                            @error('card_name')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kart Numarası -->
                        <div class="mb-3">
                            <label for="card_number" class="form-label small fw-bold text-muted">Kart Numarası</label>
                            <input type="text" name="card_number" id="card_number" class="form-control shadow-none @error('card_number') is-invalid @enderror" placeholder="4355 1234 5678 9012" value="{{ old('card_number') }}">
                            @error('card_number')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row g-2">
                            <!-- Son Kullanma Tarihi -->
                            <div class="col-md-6 mb-2">
                                <label for="card_expiry" class="form-label small fw-bold text-muted">Son Kullanma Tarihi</label>
                                <input type="text" name="card_expiry" id="card_expiry" class="form-control shadow-none @error('card_expiry') is-invalid @enderror" placeholder="AA/YY" value="{{ old('card_expiry') }}">
                                @error('card_expiry')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- CVC -->
                            <div class="col-md-6 mb-2">
                                <label for="card_cvc" class="form-label small fw-bold text-muted">Güvenlik Kodu (CVC)</label>
                                <input type="text" name="card_cvc" id="card_cvc" class="form-control shadow-none @error('card_cvc') is-invalid @enderror" placeholder="123" value="{{ old('card_cvc') }}">
                                @error('card_cvc')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info border-0 p-3 rounded-3 d-flex align-items-center mb-4" role="alert">
                        <i class="fa-solid fa-circle-check fs-4 me-3 text-info"></i>
                        <div class="small fw-semibold">
                            Tebrikler! Alışveriş sepetinizin tamamı hediye bakiyenizden karşılanmaktadır. Herhangi bir kredi kartı bilgisi girmenize gerek yoktur.
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-premium-primary w-100 py-3 fs-6 rounded-3 mt-3">
                    Ödemeyi Yap ve Siparişi Tamamla <i class="fa-solid fa-shield-halved ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
