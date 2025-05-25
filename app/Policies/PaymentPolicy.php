<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'view-payment-records');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'view-payment-records');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'process-customer-payments');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'process-customer-payments');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'void-payment-transactions');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'process-customer-payments');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'void-payment-transactions');
    }

    /**
     * Determine whether the user can issue refunds.
     */
    public function issueRefund(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'issue-payment-refunds');
    }

    /**
     * Determine whether the user can void payments.
     */
    public function voidPayment(User $user, Payment $payment): bool
    {
        return $this->hasPermission($user, 'void-payment-transactions');
    }

    /**
     * Check if user has specific permission.
     */
    private function hasPermission(User $user, string $permission): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }

        $adminUser = $user->userable;
        if (!$adminUser || !$adminUser->role) {
            return false;
        }

        return $adminUser->role->permissions()
            ->where('slug', $permission)
            ->exists();
    }
}
