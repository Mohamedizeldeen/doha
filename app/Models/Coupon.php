<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    protected $fillable = [
        'salon_id', 'code', 'type', 'value',
        'min_order_amount', 'max_uses', 'used_count',
        'valid_from', 'valid_until', 'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        $now = now()->startOfDay();
        if ($this->valid_from && $now->lt($this->valid_from->startOfDay())) return false;
        if ($this->valid_until && $now->gt($this->valid_until->endOfDay())) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($amount < $this->min_order_amount) return 0;
        if ($this->type === 'percentage') {
            return round($amount * ($this->value / 100), 2);
        }
        return min($this->value, $amount);
    }
}
