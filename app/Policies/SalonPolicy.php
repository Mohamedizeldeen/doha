<?php

namespace App\Policies;

use App\Models\Salon;
use App\Models\User;

class SalonPolicy
{
    /**
     * Check if user belongs to this salon (owner, employee, or cashier)
     */
    private function belongsToSalon(User $user, Salon $salon): bool
    {
        // Admin owns the salon
        if ($user->id === $salon->user_id) return true;
        // Employee or cashier is assigned to this salon
        if (in_array($user->role, ['employee', 'cashier']) && $user->salon_id === $salon->id) return true;
        return false;
    }

    /**
     * Determine if the user owns the salon (admin, employee, or cashier)
     */
    public function own(User $user, Salon $salon): bool
    {
        return $this->belongsToSalon($user, $salon);
    }

    /**
     * Determine if the user can view the salon
     */
    public function view(User $user, Salon $salon): bool
    {
        return $this->belongsToSalon($user, $salon);
    }

    /**
     * Determine if the user can update the salon
     */
    public function update(User $user, Salon $salon): bool
    {
        return $user->id === $salon->user_id;
    }

    /**
     * Determine if the user can delete the salon
     */
    public function delete(User $user, Salon $salon): bool
    {
        return $user->id === $salon->user_id;
    }
}
