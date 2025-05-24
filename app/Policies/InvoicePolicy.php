<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'view-invoice-records');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'view-invoice-records');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'generate-customer-invoices');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'modify-invoice-details');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'delete-invoice-records');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'modify-invoice-details');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'delete-invoice-records');
    }

    /**
     * Determine whether the user can mark invoice as paid.
     */
    public function markAsPaid(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'mark-invoices-as-paid');
    }

    /**
     * Determine whether the user can record payments.
     */
    public function recordPayment(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'record-invoice-payments');
    }

    /**
     * Determine whether the user can send invoice emails.
     */
    public function sendEmail(User $user, Invoice $invoice): bool
    {
        return $this->hasPermission($user, 'send-invoice-emails');
    }

    /**
     * Determine whether the user can generate invoices from orders.
     */
    public function generateFromOrder(User $user): bool
    {
        return $this->hasPermission($user, 'generate-invoices-from-orders');
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
