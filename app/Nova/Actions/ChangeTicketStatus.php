<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\AdminUser;

class ChangeTicketStatus extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Change Status';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(\App\Services\TicketService::class);
        $updatedCount = 0;
        $invalidCount = 0;

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Delegate to service
                    $ticketService->changeStatus($ticket, $fields->status, $fields->notes);
                    $updatedCount++;
                } catch (\Exception $e) {
                    $invalidCount++;
                }
            }
        }

        $message = "Successfully updated status for {$updatedCount} ticket(s).";
        if ($invalidCount > 0) {
            $message .= " {$invalidCount} ticket(s) had invalid status transitions.";
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
        return [
            Select::make('New Status', 'status')
                ->options(Ticket::getStatuses())
                ->rules('required')
                ->help('Select the new status for the ticket(s)'),

            Textarea::make('Notes')
                ->nullable()
                ->rows(3)
                ->help('Optional notes about the status change (will be added to internal notes)'),
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
