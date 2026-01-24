<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'salon_id',
        'client_id',
        'service_id',
        'staff_id',
        'appointment_datetime',
        'status',
        'price',
        'notes',
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get the salon this booking belongs to
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get the client for this booking
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the service for this booking
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the staff member for this booking
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Check if booking is in past
     */
    public function isPast(): bool
    {
        return $this->appointment_datetime < now();
    }

    /**
     * Check if booking is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->appointment_datetime >= now() && $this->status === 'scheduled';
    }
}
