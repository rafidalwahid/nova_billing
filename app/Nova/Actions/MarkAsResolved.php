<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\AdminUser;

class MarkAsResolved extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Mark as Resolved';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(\App\Services\TicketService::class);
        $resolvedCount = 0;
        $errors = [];

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Only resolve if not already resolved or closed
                    if (in_array($ticket->status, [Ticket::STATUS_RESOLVED, Ticket::STATUS_CLOSED])) {
                        $errors[] = "Ticket #{$ticket->ticket_number} is already {$ticket->status}";
                        continue;
                    }

                    // Change status to resolved
                    $ticketService->changeStatus($ticket, Ticket::STATUS_RESOLVED, 'Ticket marked as resolved');
                    $resolvedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Ticket #{$ticket->ticket_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some tickets could not be resolved: ' . implode('; ', $errors));
        }

        return Action::message("Successfully resolved {$resolvedCount} ticket(s).");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            // No fields needed - this is a quick action
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

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToRun(\Illuminate\Http\Request $request, $model)
    {
        // Only allow on open or in-progress tickets
        if ($model instanceof Ticket) {
            return in_array($model->status, [Ticket::STATUS_OPEN, Ticket::STATUS_IN_PROGRESS]);
        }

        return false;
    }
}
