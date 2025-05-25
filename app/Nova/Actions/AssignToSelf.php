<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\AdminUser;

class AssignToSelf extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Assign to Self';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $user = auth()->user();
        
        // Get the admin user record for the authenticated user
        $adminUser = AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->first();

        if (!$adminUser) {
            return Action::danger('You must be a staff member to assign tickets to yourself.');
        }

        $assignedCount = 0;
        $skippedCount = 0;

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                // Only assign if not already assigned to someone else
                if (empty($ticket->assigned_to)) {
                    $ticket->update([
                        'assigned_to' => $adminUser->id,
                        'status' => $ticket->status === Ticket::STATUS_OPEN ? Ticket::STATUS_IN_PROGRESS : $ticket->status,
                    ]);
                    $assignedCount++;
                } else {
                    $skippedCount++;
                }
            }
        }

        $message = "Successfully assigned {$assignedCount} ticket(s) to yourself.";
        if ($skippedCount > 0) {
            $message .= " Skipped {$skippedCount} already assigned ticket(s).";
        }

        return Action::message($message);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [];
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

        // Check if user is an admin user (staff member)
        return AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->exists();
    }
}
