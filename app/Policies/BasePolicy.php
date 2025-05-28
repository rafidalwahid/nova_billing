<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminUser;

abstract class BasePolicy
{
    /**
     * Check if user has specific permission through their role.
     * This provides a consistent permission checking mechanism across all policies.
     */
    protected function hasPermission(User $user, string $permissionSlug): bool
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

    /**
     * Check if user is a customer and owns the resource.
     */
    protected function isCustomerOwner(User $user, $resource, string $customerIdField = 'customer_id'): bool
    {
        if (!$user->isCustomer()) {
            return false;
        }

        return $resource->{$customerIdField} === $user->userable_id;
    }

    /**
     * Check if user can view any resources of this type.
     * Customers can view their own data, staff need permissions.
     */
    protected function canViewAny(User $user, string $permissionSlug, bool $allowCustomers = true): bool
    {
        // Customers can view their own data (filtered by policies)
        if ($allowCustomers && $user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can view a specific resource.
     * Customers can only view their own data, staff need permissions.
     */
    protected function canView(User $user, $resource, string $permissionSlug, string $customerIdField = 'customer_id'): bool
    {
        // Customers can only view their own data
        if ($user->isCustomer()) {
            return $this->isCustomerOwner($user, $resource, $customerIdField);
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can create resources.
     * Usually only staff can create, but some resources allow customer creation.
     */
    protected function canCreate(User $user, string $permissionSlug, bool $allowCustomers = false): bool
    {
        // Some resources allow customer creation (like tickets)
        if ($allowCustomers && $user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can update a resource.
     * Customers usually cannot update, staff need permissions.
     */
    protected function canUpdate(User $user, $resource, string $permissionSlug, bool $allowCustomers = false, string $customerIdField = 'customer_id'): bool
    {
        // Some resources allow customer updates
        if ($allowCustomers && $user->isCustomer()) {
            return $this->isCustomerOwner($user, $resource, $customerIdField);
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can delete a resource.
     * Usually only staff can delete.
     */
    protected function canDelete(User $user, string $permissionSlug): bool
    {
        // Only staff users can delete
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can restore a resource.
     * Usually only staff can restore.
     */
    protected function canRestore(User $user, string $permissionSlug): bool
    {
        // Only staff users can restore
        return $this->hasPermission($user, $permissionSlug);
    }

    /**
     * Check if user can force delete a resource.
     * Usually only staff can force delete.
     */
    protected function canForceDelete(User $user, string $permissionSlug): bool
    {
        // Only staff users can force delete
        return $this->hasPermission($user, $permissionSlug);
    }
}
