<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'sales_user_id',
        'subscription_type',
        'amount',
        'commission_rate',
        'commission_amount',
        'period_start',
        'period_end',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    /**
     * Subscription pricing constants (OMR)
     */
    const PRICE_MONTHLY = 15.00;
    const PRICE_YEARLY = 120.00;

    /**
     * Get price for a subscription type
     */
    public static function getPriceForType(string $type): float
    {
        return match ($type) {
            'monthly' => self::PRICE_MONTHLY,
            'yearly' => self::PRICE_YEARLY,
            default => 0,
        };
    }

    /**
     * The salon this payment belongs to.
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * The sales user who gets commission from this payment.
     */
    public function salesUser()
    {
        return $this->belongsTo(User::class, 'sales_user_id');
    }

    /**
     * Scope for paid payments only.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Record a subscription payment and calculate commission automatically.
     */
    public static function recordPayment(Salon $salon, string $subscriptionType, ?string $notes = null): self
    {
        $amount = self::getPriceForType($subscriptionType);
        $salesUser = $salon->salesUser;

        $commissionRate = 0;
        $commissionAmount = 0;

        if ($salesUser && $salesUser->commission_rate > 0) {
            $commissionRate = $salesUser->commission_rate;
            $commissionAmount = $amount * ($commissionRate / 100);
        }

        // Calculate period
        $periodStart = now();
        $periodEnd = $subscriptionType === 'monthly'
            ? now()->addDays(30)
            : now()->addDays(365);

        $payment = self::create([
            'salon_id' => $salon->id,
            'sales_user_id' => $salesUser?->id,
            'subscription_type' => $subscriptionType,
            'amount' => $amount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'status' => 'paid',
            'notes' => $notes,
        ]);

        // Update salon subscription dates
        $salon->update([
            'subscription_type' => $subscriptionType,
            'subscription_start_date' => $periodStart,
            'subscription_end_date' => $periodEnd,
        ]);

        return $payment;
    }
}
