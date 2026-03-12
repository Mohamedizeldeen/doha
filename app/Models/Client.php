<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'salon_id',
        'client_code',
        'name_en',
        'name_ar',
        'phone',
        'email',
        'notes',
        'birthday',
        'preferences',
        'loyalty_points',
    ];

    protected $casts = [
        'birthday' => 'date',
        'preferences' => 'array',
        'loyalty_points' => 'integer',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public static function findExisting($salonId, $phone = null, $email = null)
    {
        $query = self::where('salon_id', $salonId);
        if ($phone) $query->where('phone', $phone);
        if ($email) $query->where('email', $email);
        return $query->first();
    }

    public function getTotalSpending(): float
    {
        return $this->bookings()->where('status', 'completed')->sum('price');
    }

    public function getVisitCount(): int
    {
        return $this->bookings()->where('status', 'completed')->count();
    }

    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
    }

    public function redeemPoints(int $points): bool
    {
        if ($this->loyalty_points >= $points) {
            $this->decrement('loyalty_points', $points);
            return true;
        }
        return false;
    }

    public function hasBirthdayToday(): bool
    {
        if (!$this->birthday) return false;
        return $this->birthday->format('m-d') === now()->format('m-d');
    }
}
