@extends('layouts.app')

@section('title', 'Yönetici Kontrol Paneli')

@section('content')
<!-- Yönetici Üst Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-white bg-dark">
            <div class="card-body p-4 p-md-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold mb-1"><i class="fa-solid fa-screwdriver-wrench text-warning me-2"></i>Sistem Yönetim Konsolu</h3>
                    <p class="text-muted small mb-0">Asansör yedek parçaları e-ticaret sitenizi, siparişlerinizi ve üyelerinizi buradan yönetebilirsiniz.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products') }}" class="btn btn-warning btn-sm px-3 rounded-pill fw-semibold text-dark">
                        <i class="fa-solid fa-cubes me-1"></i> Ürün Yönetimi
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill fw-semibold">
                        <i class="fa-solid fa-users me-1"></i> Üye Yönetimi
                    </a>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill fw-semibold">
                        <i class="fa-solid fa-box-open me-1"></i> Sipariş Süreci
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- API Widget'ları (Hava Durumu ve Döviz Kurları) -->
<div class="row g-4 mb-4">
    <!-- Kocaeli Canlı Hava Durumu API Widget -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-muted mb-0">
                    <i class="fa-solid fa-cloud-sun text-primary me-2"></i>Canlı Hava Durumu (Kocaeli)
                </h6>
                @if($weatherData['offline'])
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill font-monospace" style="font-size: 0.7rem;">Çevrimdışı Mod</span>
                @else
                    <span class="badge bg-success-subtle text-success rounded-pill font-monospace" style="font-size: 0.7rem;">Canlı (Open-Meteo)</span>
                @endif
            </div>
            
            <div class="d-flex align-items-center gap-4 py-2">
                <div class="display-3 text-primary">
                    @if($weatherData['icon'] === 'sun')
                        <i class="fa-solid fa-sun text-warning"></i>
                    @elseif($weatherData['icon'] === 'cloud-sun')
                        <i class="fa-solid fa-cloud-sun text-info"></i>
                    @elseif($weatherData['icon'] === 'cloud')
                        <i class="fa-solid fa-cloud text-secondary"></i>
                    @elseif($weatherData['icon'] === 'cloud-fog')
                        <i class="fa-solid fa-smog text-muted"></i>
                    @elseif($weatherData['icon'] === 'cloud-drizzle' || $weatherData['icon'] === 'cloud-rain')
                        <i class="fa-solid fa-cloud-showers-heavy text-primary"></i>
                    @elseif($weatherData['icon'] === 'snowflake')
                        <i class="fa-solid fa-snowflake text-info"></i>
                    @else
                        <i class="fa-solid fa-cloud-bolt text-danger"></i>
                    @endif
                </div>
                <div>
                    <span class="d-block display-6 fw-bold text-dark font-monospace">{{ $weatherData['temp'] }}°C</span>
                    <span class="d-block fw-semibold text-secondary" style="font-size: 1.05rem;">{{ $weatherData['desc'] }}</span>
                </div>
            </div>
            <p class="small text-muted mb-0 mt-3 border-top pt-2">
                Lojistik ve sevkiyat planlamalarınız için Kocaeli/İzmit hava durumunu anlık takip edin.
            </p>
        </div>
    </div>

    <!-- Canlı Döviz Kurları API Widget -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 bg-white h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-muted mb-0">
                    <i class="fa-solid fa-chart-line text-success me-2"></i>Canlı Döviz Kurları (TCMB Karşılığı)
                </h6>
                @if($exchangeRates['offline'])
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill font-monospace" style="font-size: 0.7rem;">Çevrimdışı Mod</span>
                @else
                    <span class="badge bg-success-subtle text-success rounded-pill font-monospace" style="font-size: 0.7rem;">Canlı (Exchange API)</span>
                @endif
            </div>

            <div class="row g-3 py-2 text-center">
                <!-- USD Döviz -->
                <div class="col-6 border-end">
                    <span class="d-block text-muted small fw-bold">1 USD ($)</span>
                    <strong class="fs-4 text-dark font-monospace">₺{{ $exchangeRates['usd'] }}</strong>
                </div>
                <!-- EUR Döviz -->
                <div class="col-6">
                    <span class="d-block text-muted small fw-bold">1 EUR (€)</span>
                    <strong class="fs-4 text-dark font-monospace">₺{{ $exchangeRates['eur'] }}</strong>
                </div>
            </div>
            <p class="small text-muted mb-0 mt-3 border-top pt-2">
                Asansör parça ithalat maliyetleri ve fiyat güncellemeleri için anlık döviz takibi.
            </p>
        </div>
    </div>
</div>

<!-- İstatistik Panelleri -->
<div class="row g-3 mb-4">
    <!-- Toplam Satış Hasılatı -->
    <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Toplam Satış Tutarı</span>
                    <h4 class="fw-extrabold text-success mt-2 font-monospace">₺{{ number_format($totalSales, 2, ',', '.') }}</h4>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-3">
                    <i class="fa-solid fa-money-bill-trend-up fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Onay Bekleyen Siparişler -->
    <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Bekleyen Onaylar</span>
                    <h4 class="fw-extrabold text-warning mt-2 font-monospace">{{ $pendingOrdersCount }} Sipariş</h4>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-3">
                    <i class="fa-solid fa-hourglass-half fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kayıtlı Üyeler -->
    <div class="col-md-4 col-sm-12">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Toplam Müşteri Sayısı</span>
                    <h4 class="fw-extrabold text-primary mt-2 font-monospace">{{ $totalUsersCount }} Üye</h4>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-3">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Son 5 Sipariş Tablosu -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-receipt text-primary me-2"></i>Son Gelen Siparişler</h5>
            @if($recentOrders->isEmpty())
                <div class="text-center py-4 text-muted small">Sistemde henüz bir sipariş bulunmuyor.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>Sipariş No</th>
                                <th>Müşteri</th>
                                <th>Ödeme Yöntemi</th>
                                <th class="text-center">Tutar</th>
                                <th class="text-center">Durum</th>
                                <th class="text-end">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong class="text-dark">{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->user ? $order->user->name : 'Silinmiş Kullanıcı' }}</td>
                                    <td>
                                        @if($order->payment_method === 'credit_card')
                                            <span class="badge bg-light text-dark border">Kredi Kartı</span>
                                        @elseif($order->payment_method === 'balance')
                                            <span class="badge bg-success-subtle text-success">Bakiye</span>
                                        @else
                                            <span class="badge bg-info-subtle text-info-emphasis">Bakiye + Kart</span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold">₺{{ number_format($order->total_price, 2, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($order->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill">Onay Bekliyor</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge bg-success px-3 py-1 rounded-pill">Tamamlandı</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill">İptal Edildi</span>
                                        @else
                                            <span class="badge bg-primary px-3 py-1 rounded-pill">İşlemde</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                            Süreci Yönet <i class="fa-solid fa-chevron-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
