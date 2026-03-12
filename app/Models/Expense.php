<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'salon_id', 'category', 'description',
        'amount', 'supplier_name', 'expense_date',
        'receipt_image', 'notes',
        'vat_amount', 'vat_rate', 'is_recurring', 'recurring_period',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'expense_date' => 'date',
        'is_recurring' => 'boolean',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public static function categories(): array
    {
        return [
            'rent' => ['en' => 'Rent', 'ar' => 'إيجار'],
            'salary' => ['en' => 'Salaries', 'ar' => 'رواتب'],
            'supplier' => ['en' => 'Supplier / Materials', 'ar' => 'مورد / مواد'],
            'utilities' => ['en' => 'Utilities', 'ar' => 'مرافق (كهرباء/ماء)'],
            'marketing' => ['en' => 'Marketing', 'ar' => 'تسويق'],
            'maintenance' => ['en' => 'Maintenance', 'ar' => 'صيانة'],
            'equipment' => ['en' => 'Equipment', 'ar' => 'معدات'],
            'insurance' => ['en' => 'Insurance', 'ar' => 'تأمين'],
            'other' => ['en' => 'Other', 'ar' => 'أخرى'],
        ];
    }
}
