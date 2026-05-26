@extends('layouts.app')

@section('title', 'Ürünü Düzenle: ' . $product->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Teknik Ürünü Düzenle
                </h4>
                <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Listeye Dön
                </a>
            </div>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Ürün Adı -->
                    <div class="col-md-12">
                        <label for="name" class="form-label small fw-bold text-muted">Ürün Adı</label>
                        <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6">
                        <label for="category" class="form-label small fw-bold text-muted">Ürün Kategorisi</label>
                        <select name="category" id="category" class="form-select shadow-none @error('category') is-invalid @enderror" required>
                            <option value="">Seçiniz...</option>
                            <option value="Motor" {{ old('category', $product->category) === 'Motor' ? 'selected' : '' }}>Motor & Makine</option>
                            <option value="Kumanda Panosu" {{ old('category', $product->category) === 'Kumanda Panosu' ? 'selected' : '' }}>Kumanda Panosu</option>
                            <option value="Halat" {{ old('category', $product->category) === 'Halat' ? 'selected' : '' }}>Çelik Halat & Ekipmanlar</option>
                            <option value="Kabin Kaseti" {{ old('category', $product->category) === 'Kabin Kaseti' ? 'selected' : '' }}>Kabin Kaseti (COP/LOP)</option>
                            <option value="Kapı Kilidi" {{ old('category', $product->category) === 'Kapı Kilidi' ? 'selected' : '' }}>Kapı Kilidi & Mekanizma</option>
                            <option value="Diğer" {{ old('category', $product->category) === 'Diğer' ? 'selected' : '' }}>Diğer Aksesuarlar</option>
                        </select>
                        @error('category')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Fiyat -->
                    <div class="col-md-3">
                        <label for="price" class="form-label small fw-bold text-muted">Birim Fiyatı (TL)</label>
                        <input type="number" name="price" id="price" step="0.01" class="form-control shadow-none @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div class="col-md-3">
                        <label for="stock" class="form-label small fw-bold text-muted">Mevcut Stok</label>
                        <input type="number" name="stock" id="stock" class="form-control shadow-none @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                        @error('stock')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mevcut Ürün Görseli Gösterimi -->
                    @if($product->image_path)
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted d-block">Mevcut Görsel</label>
                            <div class="d-inline-block border p-2 bg-light rounded-3">
                                <img src="{{ asset($product->image_path) }}" class="img-fluid rounded-3" style="max-height: 120px;" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endif

                    <!-- Ürün Görseli Güncelle -->
                    <div class="col-md-12">
                        <label for="image" class="form-label small fw-bold text-muted">Görseli Güncelle / Değiştir</label>
                        <input type="file" name="image" id="image" class="form-control shadow-none @error('image') is-invalid @enderror">
                        <span class="text-muted d-block mt-1" style="font-size: 0.75rem;">Yalnızca yeni bir görsel yüklemek istiyorsanız dosya seçin. Maksimum boyut: 2 MB.</span>
                        @error('image')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Açıklama -->
                    <div class="col-md-12">
                        <label for="description" class="form-label small fw-bold text-muted">Ürün Açıklaması</label>
                        <textarea name="description" id="description" rows="4" class="form-control shadow-none @error('description') is-invalid @enderror" placeholder="Teknik açıklamalar...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Satışta mı? (Aktiflik) -->
                    <div class="col-md-12 mt-2">
                        <div class="form-check form-switch p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                            <div>
                                <label class="form-check-label fw-bold text-dark mb-0" for="is_on_sale">Satışa Sunulsun (Katalogta Göster)</label>
                                <span class="d-block text-muted small mt-1" style="font-size: 0.75rem;">Kapatıldığında, ürün yayından kalkar fakat envanterde saklanır.</span>
                            </div>
                            <input class="form-check-input fs-5 ms-0 shadow-none" type="checkbox" name="is_on_sale" id="is_on_sale" value="1" {{ $product->is_on_sale ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <!-- Gönder Butonu -->
                <button type="submit" class="btn btn-premium-primary w-100 py-2.5 fs-6 rounded-3 mt-4">
                    Değişiklikleri Kaydet <i class="fa-solid fa-floppy-disk ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
