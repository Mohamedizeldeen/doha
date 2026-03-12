<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServicePackage extends Model
{
    protected $fillable = [
        'salon_id', 'name_en', 'name_ar',
        'description_en', 'description_ar',
        'original_price', 'package_price',
        'is_active', 'valid_from', 'valid_until',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'package_price' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'package_service')
            ->withPivot('quantity');
    }

    public function getDiscountPercentage(): float
    {
        if ($this->original_price <= 0) return 0;
        return round((($this->original_price - $this->package_price) / $this->original_price) * 100, 1);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        $now = now()->toDateString();
        if ($this->valid_from && $now < $this->valid_from) return false;
        if ($this->valid_until && $now > $this->valid_until) return false;
        return true;
    }
}
