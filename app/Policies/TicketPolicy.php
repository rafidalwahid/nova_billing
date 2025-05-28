<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Customers can view tickets (filtered to their own)
        if ($user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'support_management.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // Customers can only view their own tickets
        if ($user->isCustomer()) {
            return $this->isCustomerOwner($user, $ticket);
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'support_management.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Customers can create tickets
        if ($user->isCustomer()) {
            return true;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'support_management.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Customers cannot update tickets (only add responses)
        if ($user->isCustomer()) {
            return false;
        }

        // Staff users need proper permissions
        return $this->hasPermission($user, 'support_management.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        // Only staff users can delete tickets
        return $this->hasPermission($user, 'support_management.delete');
    }
}
