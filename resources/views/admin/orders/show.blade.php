@extends('layouts.app')

@section('title', 'Sipariş Süreci Yönetimi #' . $order->order_number)

@section('content')
<div class="row g-4">
    <!-- Sol Taraf: Sipariş Detayları ve Ürünler -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5 mb-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                <div>
                    <span class="text-muted small d-block">Yönetilen Sipariş</span>
                    <h4 class="fw-bold text-dark mb-0">{{ $order->order_number }}</h4>
                </div>
                <div class="text-end">
                    <span class="text-muted small d-block">Sipariş Tarihi</span>
                    <span class="fw-bold font-monospace small text-dark">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>

            <!-- Müşteri Bilgileri -->
            <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-user-tag text-primary me-2"></i>Müşteri Bilgileri</h5>
            <div class="row g-3 mb-4 bg-light p-3 rounded-3">
                <div class="col-md-6">
                    <span class="text-muted small d-block">Adı Soyadı / Firma:</span>
                    <strong class="text-dark">{{ $order->user ? $order->user->name : 'Silinmiş Kullanıcı' }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">E-Posta Adresi:</span>
                    <span class="text-dark small font-monospace">{{ $order->user ? $order->user->email : 'Silinmiş' }}</span>
                </div>
            </div>

            <!-- Sipariş Verilen Parçalar -->
            <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-boxes-packing text-primary me-2"></i>Siparişteki Ürünler</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small fw-bold">
                            <th>Ürün Adı</th>
                            <th class="text-center">Birim Fiyat</th>
                            <th class="text-center">Miktar</th>
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

    <!-- Sağ Taraf: Süreç Yönetimi Kontrol Konsolu -->
    <div class="col-lg-4">
        <!-- SÜREÇ YÖNETİM PANELİ -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 mb-4">
            <h5 class="fw-bold mb-4 text-dark">
                <i class="fa-solid fa-gears text-primary me-2"></i>Süreç Yönetimi
            </h5>

            <!-- Mevcut Durum Bilgisi -->
            <div class="mb-4">
                <span class="text-muted small d-block mb-1">Mevcut Sipariş Aşaması:</span>
                @if($order->status === 'pending')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-regular fa-clock me-1"></i> Onay Bekliyor
                    </span>
                @elseif($order->status === 'supplied')
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-gears me-1"></i> Tedarik Ediliyor
                    </span>
                @elseif($order->status === 'packaged')
                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-box me-1"></i> Kutulanıyor
                    </span>
                @elseif($order->status === 'shipping')
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-truck me-1"></i> Kargoya Verildi
                    </span>
                @elseif($order->status === 'transit')
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-route me-1"></i> Yolda
                    </span>
                @elseif($order->status === 'delivered')
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-circle-check me-1"></i> Teslim Edildi
                    </span>
                @elseif($order->status === 'completed')
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-circle-check me-1"></i> Tamamlandı
                    </span>
                @elseif($order->status === 'cancelled')
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold w-100 fs-6 text-center">
                        <i class="fa-solid fa-circle-xmark me-1"></i> İptal Edildi
                    </span>
                @endif
            </div>

            <hr class="opacity-10 my-3">

            <!-- Süreci İlerletme Arayüzü -->
            @if(in_array($order->status, ['pending', 'supplied', 'packaged', 'shipping', 'transit']))
                <div class="bg-light p-3 rounded-3 text-center mb-3">
                    <span class="d-block small text-muted mb-3 fw-semibold">Sonraki Aşamaya Geçir:</span>
                    
                    <form action="{{ route('admin.orders.advance', $order->id) }}" method="POST">
                        @csrf
                        @if($order->status === 'pending')
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                                Siparişi Onayla & Başlat <i class="fa-solid fa-circle-check ms-1"></i>
                            </button>
                            <span class="d-block small text-muted mt-2" style="font-size: 0.75rem;">Süreç 'Tedarik Ediliyor' aşamasına geçecektir. Müşteri artık siparişi iptal edemez.</span>
                        @elseif($order->status === 'supplied')
                            <button type="submit" class="btn btn-info w-100 py-2 rounded-pill fw-bold text-dark">
                                Kutulama Aşamasına Al <i class="fa-solid fa-box ms-1"></i>
                            </button>
                        @elseif($order->status === 'packaged')
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                                Kargoya Verildi Yap <i class="fa-solid fa-truck ms-1"></i>
                            </button>
                        @elseif($order->status === 'shipping')
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                                Yolda Aşamasına Geçir <i class="fa-solid fa-route ms-1"></i>
                            </button>
                        @elseif($order->status === 'transit')
                            <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-bold">
                                Alıcıya Teslim Et <i class="fa-solid fa-circle-check ms-1"></i>
                            </button>
                        @endif
                    </form>
                </div>
            @elseif($order->status === 'delivered')
                <div class="alert alert-info border-0 p-3 rounded-3 small mb-0 fw-semibold text-center">
                    Sipariş müşteriye teslim edilmiştir. Müşterinin kendi panelinden "Ürünlerimi Teslim Aldım" onayı vermesi beklenmektedir.
                </div>
            @elseif($order->status === 'completed')
                <div class="alert alert-success border-0 p-3 rounded-3 small mb-0 fw-semibold text-center">
                    Müşteri siparişi teslim aldığını onayladı. Süreç başarıyla tamamlanmıştır.
                </div>
            @elseif($order->status === 'cancelled')
                <div class="alert alert-danger border-0 p-3 rounded-3 small mb-0 fw-semibold text-center">
                    Bu sipariş iptal edilmiştir. Süreç ilerletilemez.
                </div>
            @endif
        </div>

        <!-- Sevk & Ödeme Detayları -->
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-truck-ramp-box text-primary me-2"></i>Sevk & Ücret</h5>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted mb-1">Müşteri İletişim Numarası</label>
                <span class="d-block text-dark fw-semibold">{{ $order->phone ?: 'Girilmemiş' }}</span>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted mb-1">Sevk Adresi</label>
                <p class="text-dark small leading-relaxed mb-0">{{ $order->shipping_address }}</p>
            </div>

            <hr class="opacity-10 my-3">

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
    </div>
</div>
@endsection
