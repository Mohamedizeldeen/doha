<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryPayment extends Model
{
    protected $fillable = [
        'salon_id', 'staff_id', 'base_salary', 'commission_amount',
        'bonus', 'deductions', 'total_amount', 'month',
        'status', 'paid_date', 'notes',
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_date' => 'date',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
