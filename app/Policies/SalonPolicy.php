<?php

namespace App\Policies;

use App\Models\Salon;
use App\Models\User;

class SalonPolicy
{
    /**
     * Determine if the user owns the salon
     */
    public function own(User $user, Salon $salon): bool
    {
        return $user->id === $salon->user_id;
    }

    /**
     * Determine if the user can view the salon
     */
    public function view(User $user, Salon $salon): bool
    {
        return $user->id === $salon->user_id;
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
