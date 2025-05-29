<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\AdminUser;
use App\Models\Department;

class ReassignTicket extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Reassign Ticket';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(\App\Services\TicketService::class);
        $assignedToId = $fields->assigned_to;
        $departmentId = $fields->department_id;
        $reassignedCount = 0;
        $errors = [];

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Use service for consistent business logic
                    $success = $ticketService->reassignTicket($ticket, $assignedToId, $departmentId);
                    if ($success) {
                        $reassignedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Ticket #{$ticket->ticket_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some reassignments failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully reassigned {$reassignedCount} ticket(s).");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Assign to Staff Member', 'assigned_to')
                ->options(AdminUser::with('user')->get()->mapWithKeys(function ($admin) {
                    return [$admin->id => $admin->full_name . ' (' . $admin->user->email . ')'];
                }))
                ->nullable()
                ->searchable()
                ->help('Select a staff member to assign the ticket to'),

            Select::make('Department', 'department_id')
                ->options(Department::pluck('name', 'id'))
                ->nullable()
                ->searchable()
                ->help('Select a department to assign the ticket to'),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        // Only show to authenticated staff members
        $user = $request->user();
        if (!$user) {
            return false;
        }

        return AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->exists();
    }
}
