@extends('layouts.app')

@section('title', 'Ürün Yönetimi')

@section('content')
<div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold mb-0">
            <i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Ürün Envanteri
        </h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-premium-primary rounded-pill px-4">
            <i class="fa-solid fa-plus me-1"></i> Yeni Ürün Ekle
        </a>
    </div>

    @if($products->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-box-open display-1 mb-4 opacity-30"></i>
            <h5>Envanterde henüz ürün bulunmuyor.</h5>
            <p class="small">Hemen yeni bir asansör parçası ekleyerek satışa sunabilirsiniz.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th scope="col" style="width: 80px;">Görsel</th>
                        <th scope="col">Ürün Adı</th>
                        <th scope="col">Kategori</th>
                        <th scope="col" class="text-center">Stok</th>
                        <th scope="col" class="text-center">Fiyat</th>
                        <th scope="col" class="text-center">Durum</th>
                        <th scope="col" class="text-end" style="width: 180px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-bottom">
                            <!-- Ürün Resmi -->
                            <td>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center overflow-hidden" style="width: 60px; height: 60px;">
                                    @if($product->image_path)
                                        <img src="{{ asset($product->image_path) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $product->name }}">
                                    @else
                                        <i class="fa-solid fa-elevator text-muted display-6 opacity-30"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Ürün İsmi -->
                            <td>
                                <strong class="text-dark">{{ $product->name }}</strong>
                            </td>

                            <!-- Kategori -->
                            <td>
                                <span class="badge bg-light text-secondary font-monospace">{{ $product->category }}</span>
                            </td>

                            <!-- Stok Miktarı -->
                            <td class="text-center">
                                @if($product->stock == 0)
                                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded fw-bold">Tükendi</span>
                                @elseif($product->stock <= 3)
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-2.5 py-1 rounded fw-bold">{{ $product->stock }} (Kritik!)</span>
                                @else
                                    <span class="badge bg-success-subtle text-success px-2.5 py-1 rounded fw-semibold">{{ $product->stock }} Adet</span>
                                @endif
                            </td>

                            <!-- Fiyat -->
                            <td class="text-center fw-bold text-dark font-monospace">
                                ₺{{ number_format($product->price, 2, ',', '.') }}
                            </td>

                            <!-- Satışta mı Durumu -->
                            <td class="text-center">
                                @if($product->is_on_sale)
                                    <span class="badge bg-success px-2.5 py-1 rounded fw-semibold">Satışta</span>
                                @else
                                    <span class="badge bg-secondary px-2.5 py-1 rounded fw-semibold">Yayında Değil</span>
                                @endif
                            </td>

                            <!-- İşlemler -->
                            <td class="text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm rounded" title="Düzenle">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('admin.products.delete', $product->id) }}" class="btn btn-outline-danger btn-sm rounded" onclick="return confirm('Bu ürünü envanterden tamamen silmek istediğinize emin misiniz?')" title="Sil">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
