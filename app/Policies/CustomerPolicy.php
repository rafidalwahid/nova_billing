<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Models\AdminUser;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'view-customer-accounts');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        return $this->hasPermission($user, 'view-customer-accounts');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'create-customer-accounts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $this->hasPermission($user, 'modify-customer-accounts');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return $this->hasPermission($user, 'deactivate-customer-accounts');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return $this->hasPermission($user, 'reactivate-customer-services');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        return $this->hasPermission($user, 'deactivate-customer-accounts');
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
