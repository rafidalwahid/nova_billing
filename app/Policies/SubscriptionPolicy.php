<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use App\Models\AdminUser;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Customers can view their own subscriptions
        if ($user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'subscription_management.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subscription $subscription): bool
    {
        // Customers can only view their own subscriptions
        if ($user->isCustomer()) {
            return $subscription->customer_id === $user->userable_id;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'subscription_management.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'subscription_management.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subscription $subscription): bool
    {
        return $this->hasPermission($user, 'subscription_management.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        return $this->hasPermission($user, 'subscription_management.delete');
    }

    /**
     * Check if user has specific permission.
     */
    private function hasPermission(User $user, string $permission): bool
    {
        $adminUser = AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->first();

        if (!$adminUser || !$adminUser->role) {
            return false;
        }

        return $adminUser->role->permissions()->where('slug', $permission)->exists();
    }
}
