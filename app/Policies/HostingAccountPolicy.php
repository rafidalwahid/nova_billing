<?php

namespace App\Policies;

use App\Models\HostingAccount;
use App\Models\User;

class HostingAccountPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->canViewAny($user, 'hosting_management.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->canView($user, $hostingAccount, 'hosting_management.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->canCreate($user, 'hosting_management.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->canUpdate($user, $hostingAccount, 'hosting_management.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->canDelete($user, 'hosting_management.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->canRestore($user, 'hosting_management.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->canForceDelete($user, 'hosting_management.force_delete');
    }

    /**
     * Determine whether the user can suspend/unsuspend accounts.
     */
    public function suspend(User $user, HostingAccount $hostingAccount): bool
    {
        return $this->hasPermission($user, 'hosting_management.suspend');
    }

    /**
     * Determine whether the user can access account credentials.
     */
    public function viewCredentials(User $user, HostingAccount $hostingAccount): bool
    {
        // Customers can view their own account credentials
        if ($user->isCustomer()) {
            return $this->isCustomerOwner($user, $hostingAccount);
        }

        return $this->hasPermission($user, 'hosting_management.view_credentials');
    }
}
