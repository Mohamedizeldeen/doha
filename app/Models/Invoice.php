<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'salon_id', 'client_id', 'booking_id',
        'invoice_number', 'subtotal', 'discount_amount',
        'tax_amount', 'total', 'payment_method',
        'paid_amount', 'remaining_amount', 'status',
        'coupon_code', 'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'booking_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public static function generateNumber(int $salonId): string
    {
        $count = self::where('salon_id', $salonId)->count() + 1;
        return 'INV-' . str_pad($salonId, 4, '0', STR_PAD_LEFT) . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPartial(): bool
    {
        return $this->status === 'partial';
    }
}
