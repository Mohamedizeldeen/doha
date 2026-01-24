<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'salon_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'price',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the salon this service belongs to
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get all staff members who provide this service
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'staff_service');
    }

    /**
     * Get all bookings for this service
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
