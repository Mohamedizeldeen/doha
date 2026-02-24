<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'commission_rate',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'commission_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the salons owned by this user
     */
    public function salons()
    {
        return $this->hasMany(Salon::class);
    }

    /**
     * Get salons created by this sales user
     */
    public function soldSalons()
    {
        return $this->hasMany(Salon::class, 'sales_user_id');
    }

    /**
     * Check if user is a sales person
     */
    public function isSales(): bool
    {
        return $this->role === 'sales';
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get commission payments earned by this sales user
     */
    public function commissionPayments()
    {
        return $this->hasMany(Payment::class, 'sales_user_id');
    }

    /**
     * Calculate total commission earned from subscription payments
     */
    public function totalCommissionEarned()
    {
        return $this->commissionPayments()->paid()->sum('commission_amount');
    }
}
