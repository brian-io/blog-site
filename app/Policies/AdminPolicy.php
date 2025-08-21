<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Determine whether the user can access admin dashboard.
     */
    public function accessAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage security settings.
     */
    public function manageSecurity(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view analytics.
     */
    public function viewAnalytics(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage system settings.
     */
    public function manageSettings(User $user): bool
    {
        return $user->isAdmin();
    }
}
