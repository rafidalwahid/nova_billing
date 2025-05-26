<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\AdminUser;
use App\Events\TicketStatusChanged;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * Change ticket status with validation and logging.
     */
    public function changeStatus(Ticket $ticket, string $newStatus, string $notes = null): bool
    {
        // Validate status transition
        if (!$this->isValidStatusTransition($ticket->status, $newStatus)) {
            throw new \InvalidArgumentException("Invalid status transition from {$ticket->status} to {$newStatus}");
        }

        $oldStatus = $ticket->status;

        // Prepare update data
        $updateData = ['status' => $newStatus];

        // Add notes to internal notes if provided
        if ($notes) {
            $updateData['internal_notes'] = $this->appendToInternalNotes(
                $ticket->internal_notes,
                $newStatus,
                $notes
            );
        }

        // Update the ticket
        $ticket->update($updateData);

        // Fire event
        event(new TicketStatusChanged($ticket, $oldStatus, $newStatus));

        // Log the change
        $this->logStatusChange($ticket, $oldStatus, $newStatus, $notes);

        return true;
    }

    /**
     * Reassign ticket to different staff member or department.
     */
    public function reassignTicket(Ticket $ticket, int $assignedToId = null, int $departmentId = null): bool
    {
        $updateData = [];

        if ($assignedToId) {
            $updateData['assigned_to'] = $assignedToId;

            // If assigning to someone, set status to in progress if it's open
            if ($ticket->status === Ticket::STATUS_OPEN) {
                $updateData['status'] = Ticket::STATUS_IN_PROGRESS;
            }
        }

        if ($departmentId) {
            $updateData['department_id'] = $departmentId;
        }

        if (empty($updateData)) {
            return false;
        }

        $ticket->update($updateData);

        // Log the reassignment
        $this->logReassignment($ticket, $assignedToId, $departmentId);

        return true;
    }

    /**
     * Assign ticket to current user.
     */
    public function assignToSelf(Ticket $ticket, int $userId): bool
    {
        // Find admin user for the current user
        $adminUser = AdminUser::whereHas('user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->first();

        if (!$adminUser) {
            throw new \InvalidArgumentException('User is not an admin user');
        }

        return $this->reassignTicket($ticket, $adminUser->id);
    }

    /**
     * Add a response to a ticket.
     */
    public function addResponse(Ticket $ticket, array $responseData): TicketResponse
    {
        $response = TicketResponse::create([
            'ticket_id' => $ticket->id,
            'admin_user_id' => $responseData['admin_user_id'] ?? null,
            'user_id' => $responseData['user_id'] ?? null,
            'type' => $responseData['is_internal'] ? TicketResponse::TYPE_INTERNAL : TicketResponse::TYPE_STAFF,
            'message' => $responseData['message'],
            'is_internal' => $responseData['is_internal'] ?? false,
            'response_time_minutes' => $this->calculateResponseTime($ticket),
        ]);

        // Update ticket's last response time
        $ticket->update(['updated_at' => now()]);

        // Log the response
        $this->logResponseAdded($ticket, $response);

        return $response;
    }

    /**
     * Escalate a ticket to higher priority or different department.
     */
    public function escalateTicket(Ticket $ticket, string $reason = null): bool
    {
        // Increase priority if possible
        $newPriority = $this->getEscalatedPriority($ticket->priority);

        $updateData = ['priority' => $newPriority];

        // Add escalation note
        if ($reason) {
            $updateData['internal_notes'] = $this->appendToInternalNotes(
                $ticket->internal_notes,
                'escalated',
                "Escalated: {$reason}"
            );
        }

        $ticket->update($updateData);

        // Log the escalation
        $this->logEscalation($ticket, $reason);

        return true;
    }

    /**
     * Append text to internal notes with timestamp and user info.
     */
    protected function appendToInternalNotes(string $existingNotes = null, string $action, string $notes): string
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $user = auth()->user();
        $userName = $user->name ?? 'System';

        $newNote = "[{$timestamp}] {$userName}: " . ucfirst(str_replace('_', ' ', $action));
        if ($notes) {
            $newNote .= " - {$notes}";
        }

        return $existingNotes ? $existingNotes . "\n\n" . $newNote : $newNote;
    }

    /**
     * Calculate response time in minutes.
     */
    protected function calculateResponseTime(Ticket $ticket): int
    {
        return $ticket->created_at->diffInMinutes(now());
    }

    /**
     * Get escalated priority level.
     */
    protected function getEscalatedPriority(string $currentPriority): string
    {
        return match($currentPriority) {
            'low' => 'medium',
            'medium' => 'high',
            'high' => 'urgent',
            'urgent' => 'urgent', // Already at highest
            default => 'medium',
        };
    }

    /**
     * Log status change.
     */
    protected function logStatusChange(Ticket $ticket, string $oldStatus, string $newStatus, string $notes = null): void
    {
        Log::info('Ticket status changed', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Log ticket reassignment.
     */
    protected function logReassignment(Ticket $ticket, int $assignedToId = null, int $departmentId = null): void
    {
        Log::info('Ticket reassigned', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'assigned_to' => $assignedToId,
            'department_id' => $departmentId,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Log response addition.
     */
    protected function logResponseAdded(Ticket $ticket, TicketResponse $response): void
    {
        Log::info('Ticket response added', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'response_id' => $response->id,
            'is_internal' => $response->is_internal,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Log ticket escalation.
     */
    protected function logEscalation(Ticket $ticket, string $reason = null): void
    {
        Log::info('Ticket escalated', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'new_priority' => $ticket->priority,
            'reason' => $reason,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Calculate SLA due date based on priority.
     */
    public function calculateSLADueDate(string $priority): \Carbon\Carbon
    {
        $slaHours = [
            Ticket::PRIORITY_URGENT => 2,   // 2 hours
            Ticket::PRIORITY_HIGH => 8,     // 8 hours
            Ticket::PRIORITY_NORMAL => 24,  // 24 hours
            Ticket::PRIORITY_LOW => 72,     // 72 hours
        ];

        $hours = $slaHours[$priority] ?? 24;
        return now()->addHours($hours);
    }

    /**
     * Get default department for ticket category.
     */
    public function getDefaultDepartmentForCategory(string $category): ?int
    {
        $departmentMapping = [
            Ticket::CATEGORY_BILLING => 'Revenue Operations',
            Ticket::CATEGORY_TECHNICAL => 'Information Technology',
            Ticket::CATEGORY_SALES => 'Business Development',
            Ticket::CATEGORY_GENERAL => 'Customer Experience',
        ];

        $departmentName = $departmentMapping[$category] ?? 'Customer Experience';

        $department = \App\Models\Department::where('name', $departmentName)->first();
        return $department ? $department->id : null;
    }

    /**
     * Check if status transition is valid.
     */
    public function isValidStatusTransition(string $fromStatus, string $toStatus): bool
    {
        $validTransitions = [
            Ticket::STATUS_OPEN => [Ticket::STATUS_IN_PROGRESS, Ticket::STATUS_RESOLVED, Ticket::STATUS_CLOSED],
            Ticket::STATUS_IN_PROGRESS => [Ticket::STATUS_OPEN, Ticket::STATUS_RESOLVED, Ticket::STATUS_CLOSED],
            Ticket::STATUS_RESOLVED => [Ticket::STATUS_IN_PROGRESS, Ticket::STATUS_CLOSED],
            Ticket::STATUS_CLOSED => [Ticket::STATUS_IN_PROGRESS], // Can reopen if needed
        ];

        return in_array($toStatus, $validTransitions[$fromStatus] ?? []);
    }
}
