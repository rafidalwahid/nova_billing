<?php

namespace App\Policies;

use App\Models\TicketResponse;
use App\Models\User;

class TicketResponsePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Customers can view responses (filtered to their own tickets)
        if ($user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'view-ticket-responses');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketResponse $response): bool
    {
        // Customers can only view responses to their own tickets
        if ($user->isCustomer()) {
            return $response->ticket && 
                   $response->ticket->customer_id === $user->userable_id;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'view-ticket-responses');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Customers can create responses through ticket actions
        if ($user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'create-ticket-responses');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketResponse $response): bool
    {
        // Customers can edit their own responses
        if ($user->isCustomer()) {
            return $response->type === TicketResponse::TYPE_CUSTOMER &&
                   $response->ticket &&
                   $response->ticket->customer_id === $user->userable_id;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'edit-ticket-responses');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketResponse $response): bool
    {
        // Customers cannot delete responses
        if ($user->isCustomer()) {
            return false;
        }

        // Only staff users can delete responses
        return $this->hasPermission($user, 'delete-ticket-responses');
    }
}
