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
        'commission_rate',
        'salary',
        'specialization_en',
        'specialization_ar',
        'is_active',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'staff_service');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(StaffLeave::class);
    }

    public function completedBookings(): HasMany
    {
        return $this->hasMany(Book::class)->where('status', 'completed');
    }

    public function calculateCommission(float $amount): float
    {
        return round($amount * ($this->commission_rate / 100), 2);
    }

    public function getTotalRevenue(): float
    {
        return $this->bookings()->where('status', 'completed')->sum('price');
    }

    public function getTotalCommission(): float
    {
        return $this->calculateCommission($this->getTotalRevenue());
    }

    public function isOnLeave(\Carbon\Carbon $date = null): bool
    {
        $date = $date ?? now();
        return $this->leaves()
            ->where('status', 'approved')
            ->where('start_date', '<=', $date->toDateString())
            ->where('end_date', '>=', $date->toDateString())
            ->exists();
    }
}
