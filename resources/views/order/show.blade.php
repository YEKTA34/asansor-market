@extends('layouts.app')

@section('title', 'Sipariş Takibi #' . $order->order_number)

@section('content')
<div class="row g-4">
    <!-- Sol Taraf: Sipariş Bilgileri & Timeline -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5 mb-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                <div>
                    <span class="text-muted small d-block">Sipariş Numarası</span>
                    <h4 class="fw-bold text-dark mb-0">{{ $order->order_number }}</h4>
                </div>
                <div class="text-end">
                    <span class="text-muted small d-block">Sipariş Tarihi</span>
                    <span class="fw-bold font-monospace small text-dark">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>

            <!-- CANLI SÜREÇ TAKİP ÇİZELGESİ (TIMELINE) -->
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-route text-primary me-2"></i>Canlı Süreç Takibi</h5>

            @if($order->status === 'cancelled')
                <!-- İptal Edilen Sipariş Arayüzü -->
                <div class="alert alert-danger-subtle text-danger border-0 p-4 rounded-3 text-center my-4">
                    <i class="fa-solid fa-circle-xmark display-4 mb-3 d-block text-danger"></i>
                    <h5 class="fw-bold">Bu Sipariş İptal Edilmiştir!</h5>
                    <p class="small mb-0 mt-2">
                        Sipariş tutarının tamamı alışveriş hesabınıza hediye bakiye olarak iade edilmiş ve stoklar güncellenmiştir.
                    </p>
                </div>
            @elseif($order->status === 'pending')
                <!-- Onay Bekleyen Sipariş Arayüzü -->
                <div class="alert alert-warning-subtle text-warning-emphasis border-0 p-4 rounded-3 text-center my-4">
                    <i class="fa-solid fa-hourglass-half display-4 mb-3 d-block text-warning animate-pulse"></i>
                    <h5 class="fw-bold">Sipariş Yönetici Onayı Bekliyor</h5>
                    <p class="small mb-3">
                        Siparişiniz sistemimize başarıyla ulaştı. Yönetici kontrolü yapıldıktan sonra süreç hemen başlatılacaktır.
                    </p>
                    <!-- İptal Etme Butonu -->
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bu siparişi iptal etmek ve ödenen ücreti hediye bakiyenize iade almak istediğinize emin misiniz?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm px-4 rounded-pill fw-bold">
                            <i class="fa-solid fa-trash-can me-1"></i> Siparişimi İptal Et (Anında İade)
                        </button>
                    </form>
                </div>
            @else
                <!-- Canlı Aşamalı Zaman Çizelgesi -->
                @php
                    // Aşamaların sıralı listesi ve ağırlıkları
                    $stages = [
                        'supplied' => ['Tedarik Ediliyor', 'fa-gears', 1],
                        'packaged' => ['Kutulanıyor', 'fa-box', 2],
                        'shipping' => ['Kargoya Verildi', 'fa-truck', 3],
                        'transit' => ['Yola Çıktı', 'fa-route', 4],
                        'delivered' => ['Teslim Edildi', 'fa-circle-check', 5],
                    ];

                    $currentStatus = $order->status;
                    if ($currentStatus === 'completed') {
                        $currentWeight = 6;
                    } else {
                        $currentWeight = isset($stages[$currentStatus]) ? $stages[$currentStatus][2] : 0;
                    }
                @endphp

                <div class="timeline-steps">
                    @foreach($stages as $statusKey => $stageData)
                        @php
                            $isActive = $currentWeight == $stageData[2];
                            $isCompleted = $currentWeight > $stageData[2];
                        @endphp
                        <div class="timeline-step {{ $isActive ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }}">
                            <div class="timeline-step-icon">
                                <i class="fa-solid {{ $stageData[1] }}"></i>
                            </div>
                            <div class="timeline-step-label">{{ $stageData[0] }}</div>
                        </div>
                    @endforeach
                </div>

                <hr class="opacity-10 my-4">

                <!-- TESLİMAT ALINDI ONAY BUTONU -->
                <div class="text-center py-3">
                    @if($order->status === 'delivered')
                        <div class="bg-success-subtle text-success-emphasis p-4 rounded-3 border-0 mb-3">
                            <h6 class="fw-bold"><i class="fa-solid fa-box-open me-2"></i>Kargom Teslim Edildi!</h6>
                            <p class="small mb-3">Siparişiniz kargo görevlisi tarafından adresinize teslim edilmiştir. Lütfen siparişi kontrol ettikten sonra teslim aldığınızı onaylayın.</p>
                            <form action="{{ route('orders.confirm_delivery', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-check me-1"></i> Ürünlerimi Teslim Aldım
                                </button>
                            </form>
                        </div>
                    @elseif($order->status === 'completed')
                        <div class="bg-light text-muted p-4 rounded-3 border-0">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-circle-check text-success me-2"></i>Sipariş Tamamlanmıştır</h6>
                            <p class="small mb-0">Ürünlerinizi teslim aldığınızı onayladınız. Keyifli kullanımlar dileriz!</p>
                        </div>
                    @else
                        <!-- Buton Pasif / Devredışı -->
                        <div class="bg-light p-3 rounded-3 text-center border-0 text-muted">
                            <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" disabled>
                                <i class="fa-solid fa-circle-check me-1"></i> Ürünlerimi Teslim Aldım
                            </button>
                            <span class="d-block small text-muted mt-2" style="font-size: 0.75rem;">Bu buton, ürünleriniz size teslim edildiğinde aktif olacaktır.</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Ürünler Listesi -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-boxes-packing text-primary me-2"></i>Siparişteki Ürünler</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small fw-bold">
                            <th>Ürün Bilgisi</th>
                            <th class="text-center">Birim Fiyat</th>
                            <th class="text-center">Adet</th>
                            <th class="text-end">Toplam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->product)
                                        <strong class="text-dark">{{ $item->product->name }}</strong>
                                        <span class="badge bg-light text-muted font-monospace d-block w-fit mt-1" style="font-size: 0.7rem;">{{ $item->product->category }}</span>
                                    @else
                                        <span class="text-danger small">Silinmiş Ürün</span>
                                    @endif
                                </td>
                                <td class="text-center font-monospace small">₺{{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="text-center fw-semibold text-muted">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold text-primary font-monospace">₺{{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sağ Taraf: Sevk & Ödeme Detayları -->
    <div class="col-lg-4">
        <!-- Ödeme Dağılımı -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 mb-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-receipt text-primary me-2"></i>Ödeme Dağılımı</h5>
            <div class="p-3 bg-light rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">Sipariş Toplamı:</span>
                    <span class="fw-semibold">₺{{ number_format($order->total_price, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 text-success">
                    <span class="small fw-semibold">Ödenen Hediye Bakiye:</span>
                    <span class="fw-bold font-monospace">-₺{{ number_format($order->balance_used, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-top pt-2 text-primary">
                    <strong class="text-dark">Karttan Çekilen:</strong>
                    <strong class="fs-5 font-monospace">₺{{ number_format($order->card_paid_amount, 2, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Sevk Bilgileri -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-truck-ramp-box text-primary me-2"></i>Sevk Bilgileri</h5>
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted mb-1">Müşteri İletişim Telefonu</label>
                <span class="d-block text-dark fw-semibold">{{ $order->phone ?: 'Girilmemiş' }}</span>
            </div>
            <div>
                <label class="form-label small fw-bold text-muted mb-1">Teslimat ve Sevk Adresi</label>
                <p class="text-dark small leading-relaxed mb-0">{{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
