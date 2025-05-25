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
        $assignedToId = $fields->assigned_to;
        $departmentId = $fields->department_id;
        $reassignedCount = 0;

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
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

                if (!empty($updateData)) {
                    $ticket->update($updateData);
                    $reassignedCount++;
                }
            }
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
