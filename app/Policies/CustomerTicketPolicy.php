<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Customer;

/**
 * Customer Ticket Policy
 *
 * Handles authorization for customer ticket operations.
 */
class CustomerTicketPolicy
{
    /**
     * Determine if the user can view any tickets.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isCustomer();
    }

    /**
     * Determine if the user can view the ticket.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isCustomer() &&
               $user->userable_id === $ticket->customer_id;
    }

    /**
     * Determine if the user can create tickets.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    /**
     * Determine if the user can update the ticket.
     * Customers can only add responses, not update ticket properties.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return false; // Customers cannot update ticket properties
    }

    /**
     * Determine if the user can delete the ticket.
     * Customers cannot delete tickets.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return false; // Customers cannot delete tickets
    }

    /**
     * Determine if the user can add responses to the ticket.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function addResponse(User $user, Ticket $ticket): bool
    {
        return $user->isCustomer() &&
               $user->userable_id === $ticket->customer_id &&
               $ticket->status !== 'closed';
    }

    /**
     * Determine if the user can upload attachments to the ticket.
     *
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function uploadAttachment(User $user, Ticket $ticket): bool
    {
        return $user->isCustomer() &&
               $user->userable_id === $ticket->customer_id &&
               $ticket->status !== 'closed';
    }
}
