<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = [
        'salon_id',
        'name_en',
        'name_ar',
        'email',
        'phone',
        'position_en',
        'position_ar',
    ];

    /**
     * Get the salon this staff member belongs to
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get all services this staff member provides
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'staff_service');
    }

    /**
     * Get all bookings for this staff member
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
