<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffLeave extends Model
{
    protected $fillable = [
        'staff_id', 'salon_id', 'start_date',
        'end_date', 'reason', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function getDurationDays(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
