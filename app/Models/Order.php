<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'payment_method',
        'shipping_address',
        'status',
        'balance_used',
        'card_paid_amount',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'balance_used' => 'decimal:2',
        'card_paid_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $statuses = [
            'pending' => 'Yönetici Onayı Bekliyor',
            'supplied' => 'Ürünleriniz Tedarik Ediliyor',
            'packaged' => 'Ürünleriniz Kutulanıyor',
            'shipping' => 'Ürünleriniz Kargoya Veriliyor',
            'transit' => 'Ürünleriniz Yola Çıktı',
            'delivered' => 'Ürünleriniz Size Teslim Edilmiştir',
            'completed' => 'Teslim Alındı (Tamamlandı)',
            'cancelled' => 'İptal Edildi (Bakiye İade Edildi)',
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}
