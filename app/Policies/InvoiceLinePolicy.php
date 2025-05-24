<?php

namespace App\Policies;

use App\Models\InvoiceLine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoiceLinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'view-invoice-line-items');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InvoiceLine $invoiceLine): bool
    {
        return $this->hasPermission($user, 'view-invoice-line-items');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'manage-invoice-line-items');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InvoiceLine $invoiceLine): bool
    {
        return $this->hasPermission($user, 'manage-invoice-line-items');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InvoiceLine $invoiceLine): bool
    {
        return $this->hasPermission($user, 'manage-invoice-line-items');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InvoiceLine $invoiceLine): bool
    {
        return $this->hasPermission($user, 'manage-invoice-line-items');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InvoiceLine $invoiceLine): bool
    {
        return $this->hasPermission($user, 'manage-invoice-line-items');
    }

    /**
     * Check if user has specific permission through their role.
     */
    private function hasPermission(User $user, string $permissionSlug): bool
    {
        // Only admin users have roles and permissions
        if (!$user->isAdmin()) {
            return false;
        }

        $adminUser = $user->userable;
        if (!$adminUser || !$adminUser->role) {
            return false;
        }

        return $adminUser->role->permissions()
            ->where('slug', $permissionSlug)
            ->exists();
    }
}
