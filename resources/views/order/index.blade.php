@extends('layouts.app')

@section('title', 'Siparişlerim ve Takip')

@section('content')
<div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
    <h3 class="fw-bold mb-4">
        <i class="fa-solid fa-box-open text-primary me-2"></i>Siparişlerim
    </h3>

    @if($orders->isEmpty())
        <!-- Boş Sipariş Listesi -->
        <div class="text-center py-5">
            <i class="fa-solid fa-circle-info text-muted display-1 mb-4 opacity-50"></i>
            <h4 class="fw-bold text-dark">Henüz siparişiniz bulunmuyor.</h4>
            <p class="text-muted mb-4">Sepetinize ürün ekleyip ödemesini yaparak ilk siparişinizi hemen oluşturabilirsiniz.</p>
            <a href="{{ route('home') }}" class="btn btn-premium-primary px-4 rounded-pill">
                <i class="fa-solid fa-layer-group me-2"></i> Ürün Kataloğunu İncele
            </a>
        </div>
    @else
        <!-- Siparişler Tablosu -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold border-bottom">
                        <th scope="col">Sipariş No</th>
                        <th scope="col" class="text-center">Sipariş Tarihi</th>
                        <th scope="col" class="text-center">Ödeme Yöntemi</th>
                        <th scope="col" class="text-center">Toplam Tutar</th>
                        <th scope="col" class="text-center">Sipariş Durumu</th>
                        <th scope="col" class="text-end" style="width: 150px;">Detaylar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-bottom">
                            <!-- Sipariş Numarası -->
                            <td>
                                <strong class="text-dark">{{ $order->order_number }}</strong>
                            </td>

                            <!-- Sipariş Tarihi -->
                            <td class="text-center text-muted font-monospace small">
                                {{ $order->created_at->format('d.m.Y H:i') }}
                            </td>

                            <!-- Ödeme Yöntemi -->
                            <td class="text-center">
                                @if($order->payment_method === 'credit_card')
                                    <span class="badge bg-light text-dark border"><i class="fa-solid fa-credit-card me-1"></i> Kredi Kartı</span>
                                @elseif($order->payment_method === 'balance')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-wallet me-1"></i> Bakiye</span>
                                @else
                                    <span class="badge bg-info-subtle text-info-emphasis"><i class="fa-solid fa-gift me-1"></i> Bakiye + Kart</span>
                                @endif
                            </td>

                            <!-- Toplam Fiyat -->
                            <td class="text-center fw-bold text-dark">
                                ₺{{ number_format($order->total_price, 2, ',', '.') }}
                            </td>

                            <!-- Sipariş Durumu (Colored Badge) -->
                            <td class="text-center">
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-regular fa-clock me-1"></i> Onay Bekliyor
                                    </span>
                                @elseif($order->status === 'supplied')
                                    <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-gears me-1"></i> Tedarik Ediliyor
                                    </span>
                                @elseif($order->status === 'packaged')
                                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-box me-1"></i> Kutulanıyor
                                    </span>
                                @elseif($order->status === 'shipping')
                                    <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-truck me-1"></i> Kargoya Verildi
                                    </span>
                                @elseif($order->status === 'transit')
                                    <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-route me-1"></i> Yolda (Transit)
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i> Teslim Edildi
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-box-open me-1"></i> Tamamlandı
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> İptal Edildi
                                    </span>
                                @endif
                            </td>

                            <!-- Detay Linki -->
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                    Takip Et <i class="fa-solid fa-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
