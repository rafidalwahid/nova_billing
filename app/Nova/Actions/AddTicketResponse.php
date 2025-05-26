<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\AdminUser;

class AddTicketResponse extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Add Response';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(\App\Services\TicketService::class);
        $user = auth()->user();

        // Get the admin user record for the authenticated user
        $adminUser = AdminUser::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->first();

        if (!$adminUser) {
            return Action::danger('You must be a staff member to add responses.');
        }

        $responsesAdded = 0;
        $errors = [];

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Delegate to service
                    $ticketService->addResponse($ticket, [
                        'admin_user_id' => $adminUser->id,
                        'message' => $fields->message,
                        'is_internal' => $fields->is_internal,
                    ]);
                    $responsesAdded++;
                } catch (\Exception $e) {
                    $errors[] = "Ticket #{$ticket->ticket_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some responses failed: ' . implode('; ', $errors));
        }

        $responseType = $fields->is_internal ? 'internal note' : 'response';
        return Action::message("Successfully added {$responseType} to {$responsesAdded} ticket(s).");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make('Message')
                ->rules('required')
                ->rows(5)
                ->help('Enter your response or internal note'),

            Boolean::make('Internal Note', 'is_internal')
                ->default(false)
                ->help('Check if this is an internal note (not visible to customers)'),
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
