@extends('layouts.app')

@section('title', 'Sipariş Süreç Yönetimi')

@section('content')
<div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
    <h3 class="fw-bold mb-4">
        <i class="fa-solid fa-boxes-packing text-primary me-2"></i>Sipariş Süreç Yönetimi
    </h3>

    @if($orders->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-box-open display-1 mb-3 opacity-30"></i>
            <h5>Sistemde henüz kayıtlı sipariş bulunmuyor.</h5>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th scope="col">Sipariş No</th>
                        <th scope="col">Müşteri Adı</th>
                        <th scope="col" class="text-center">Sipariş Tarihi</th>
                        <th scope="col" class="text-center">Ödeme Şekli</th>
                        <th scope="col" class="text-center">Toplam Tutar</th>
                        <th scope="col" class="text-center">Mevcut Aşama</th>
                        <th scope="col" class="text-end" style="width: 150px;">Yönetim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-bottom">
                            <!-- Sipariş Numarası -->
                            <td>
                                <strong class="text-dark">{{ $order->order_number }}</strong>
                            </td>

                            <!-- Müşteri Adı -->
                            <td>
                                {{ $order->user ? $order->user->name : 'Silinmiş Kullanıcı' }}
                            </td>

                            <!-- Sipariş Tarihi -->
                            <td class="text-center text-muted font-monospace small">
                                {{ $order->created_at->format('d.m.Y H:i') }}
                            </td>

                            <!-- Ödeme Şekli -->
                            <td class="text-center">
                                @if($order->payment_method === 'credit_card')
                                    <span class="badge bg-light text-dark border">Kredi Kartı</span>
                                @elseif($order->payment_method === 'balance')
                                    <span class="badge bg-success-subtle text-success">Bakiye</span>
                                @else
                                    <span class="badge bg-info-subtle text-info-emphasis">Bakiye + Kart</span>
                                @endif
                            </td>

                            <!-- Toplam Fiyat -->
                            <td class="text-center fw-bold text-dark font-monospace">
                                ₺{{ number_format($order->total_price, 2, ',', '.') }}
                            </td>

                            <!-- Sipariş Durumu (Colored Badge) -->
                            <td class="text-center">
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold">
                                        Onay Bekliyor
                                    </span>
                                @elseif($order->status === 'supplied')
                                    <span class="badge bg-primary px-3 py-1.5 rounded-pill fw-semibold">
                                        Tedarik Ediliyor
                                    </span>
                                @elseif($order->status === 'packaged')
                                    <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fw-semibold">
                                        Kutulanıyor
                                    </span>
                                @elseif($order->status === 'shipping')
                                    <span class="badge bg-primary px-3 py-1.5 rounded-pill fw-semibold">
                                        Kargoya Verildi
                                    </span>
                                @elseif($order->status === 'transit')
                                    <span class="badge bg-primary px-3 py-1.5 rounded-pill fw-semibold">
                                        Yolda
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                        Teslim Edildi
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-success px-3 py-1.5 rounded-pill fw-semibold">
                                        Tamamlandı
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                        İptal Edildi
                                    </span>
                                @endif
                            </td>

                            <!-- Süreci Yönet Butonu -->
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                    Yönet <i class="fa-solid fa-chevron-right ms-1"></i>
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
