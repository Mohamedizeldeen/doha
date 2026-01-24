<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Salon extends Model
{
    protected $fillable = [
        'user_id',
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'phone',
        'email',
        'description_en',
        'description_ar',
        'logo',
        'subscription_type',
        'subscription_start_date',
        'subscription_end_date',
        'work_days',
        'opening_time',
        'closing_time',
        'currency',
    ];

    protected $casts = [
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'trial_end_date' => 'date',
        'work_days' => 'array',
    ];

    /**
     * Get the owner of this salon
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all staff members in this salon
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Get all services in this salon
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get all clients in this salon
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Get all bookings in this salon
     */
    public function bookings()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get all products in this salon
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Set subscription dates based on subscription type
     */
    public function setSubscriptionDates()
    {
        $today = Carbon::now();
        $this->subscription_start_date = $today->toDateString();

        if ($this->subscription_type === 'trial') {
            // Trial period is 14 days
            $this->subscription_end_date = $today->copy()->addDays(14)->toDateString();
            $this->trial_end_date = $today->copy()->addDays(14)->toDateString();
        } elseif ($this->subscription_type === 'monthly') {
            // Monthly subscription - 30 days
            $this->subscription_end_date = $today->copy()->addDays(30)->toDateString();
            $this->trial_end_date = null;
        } elseif ($this->subscription_type === 'yearly') {
            // Yearly subscription - 365 days
            $this->subscription_end_date = $today->copy()->addDays(365)->toDateString();
            $this->trial_end_date = null;
        }
    }

    /**
     * Check if subscription is active
     */
    public function isSubscriptionActive()
    {
        $today = Carbon::now()->toDateString();
        return $today <= $this->subscription_end_date;
    }

    /**
     * Check if trial is expired
     */
    public function isTrialExpired()
    {
        if ($this->subscription_type !== 'trial') {
            return false;
        }
        $today = Carbon::now()->toDateString();
        return $today > $this->trial_end_date;
    }

    /**
     * Days remaining in subscription
     */
    public function daysRemaining()
    {
        $today = Carbon::now();
        $endDate = Carbon::parse($this->subscription_end_date);
        $remaining = $endDate->diffInDays($today);
        return max(0, $remaining);
    }
}
