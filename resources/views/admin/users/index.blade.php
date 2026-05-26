@extends('layouts.app')

@section('title', 'Kullanıcı Hesap Yönetimi')

@section('content')
<div class="card border-0 shadow-sm rounded-3 bg-white p-4 p-md-5">
    <h3 class="fw-bold mb-4">
        <i class="fa-solid fa-users text-primary me-2"></i>Kullanıcı Hesap Yönetimi
    </h3>

    @if($users->isEmpty())
        <div class="text-center py-4 text-muted small">Kayıtlı herhangi bir müşteri bulunmamaktadır.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small fw-bold">
                        <th scope="col">Müşteri Bilgisi</th>
                        <th scope="col">E-Posta</th>
                        <th scope="col" class="text-center">Telefon</th>
                        <th scope="col" class="text-center">Hediye Bakiye</th>
                        <th scope="col" class="text-center">Durum</th>
                        <th scope="col" class="text-end" style="width: 250px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-bottom">
                            <!-- Kullanıcı Adı ve Rolü -->
                            <td>
                                <strong class="text-dark d-block">{{ $user->name }}</strong>
                                <span class="text-muted small" style="font-size: 0.75rem;">Kayıt Tarihi: {{ $user->created_at->format('d.m.Y') }}</span>
                            </td>

                            <!-- E-posta -->
                            <td class="small font-monospace">{{ $user->email }}</td>

                            <!-- Telefon -->
                            <td class="text-center small">{{ $user->phone ?: '-' }}</td>

                            <!-- Hediye Bakiye -->
                            <td class="text-center fw-bold text-success font-monospace">
                                ₺{{ number_format($user->balance, 2, ',', '.') }}
                            </td>

                            <!-- Durum (Aktif / Dondurulmuş) -->
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-user-slash me-1"></i> Dondurulmuş
                                    </span>
                                @endif
                            </td>

                            <!-- Aksiyon İşlemleri -->
                            <td class="text-end">
                                <div class="btn-group gap-1">
                                    <!-- Durum Değiştir (Dondur/Çöz) -->
                                    <a href="{{ route('admin.users.toggle_status', $user->id) }}" class="btn {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} btn-sm rounded-pill px-3 fw-semibold" onclick="return confirm('Bu kullanıcının hesap durumunu değiştirmek istediğinize emin misiniz?')">
                                        @if($user->is_active)
                                            <i class="fa-solid fa-user-slash me-1"></i> Hesabı Dondur
                                        @else
                                            <i class="fa-solid fa-user-check me-1"></i> Aktifleştir
                                        @endif
                                    </a>

                                    <!-- Sil -->
                                    <a href="{{ route('admin.users.delete', $user->id) }}" class="btn btn-outline-danger btn-sm rounded" onclick="return confirm('Bu kullanıcıyı sistemden tamamen silmek istediğinize emin misiniz? (Tüm bilgileri silinecektir)')" title="Kullanıcıyı Sil">
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
