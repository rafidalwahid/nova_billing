<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->canViewAny($user, 'view-invoice-records');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return $this->canView($user, $invoice, 'view-invoice-records');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->canCreate($user, 'generate-customer-invoices');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return $this->canUpdate($user, $invoice, 'modify-invoice-details');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return $this->canDelete($user, 'delete-invoice-records');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return $this->canRestore($user, 'modify-invoice-details');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $this->canForceDelete($user, 'delete-invoice-records');
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


}
