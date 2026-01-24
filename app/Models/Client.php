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
    ];

    /**
     * Get the salon this client belongs to
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get all bookings for this client
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get existing client by phone or email for a salon
     * Returns null if no client exists
     */
    public static function findExisting($salonId, $phone = null, $email = null)
    {
        $query = self::where('salon_id', $salonId);

        if ($phone) {
            $query->where('phone', $phone);
        }

        if ($email) {
            $query->where('email', $email);
        }

        return $query->first();
    }
}
