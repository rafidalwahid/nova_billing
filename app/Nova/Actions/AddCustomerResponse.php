<?php

namespace App\Nova\Actions;

use App\Models\Ticket;
use App\Services\TicketService;
use App\Services\FileUploadService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddCustomerResponse extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     */
    public $name = 'Reply to Ticket';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ticketService = app(TicketService::class);
        $user = request()->user();
        $responsesAdded = 0;
        $errors = [];

        foreach ($models as $ticket) {
            if ($ticket instanceof Ticket) {
                try {
                    // Verify customer owns this ticket
                    if (!$user->isCustomer() || $ticket->customer_id !== $user->userable_id) {
                        $errors[] = "Ticket #{$ticket->ticket_number}: Access denied";
                        continue;
                    }

                    // Add customer response using service
                    $response = $ticketService->addCustomerResponse(
                        $ticket,
                        $user,
                        $fields->message
                    );

                    // Handle file attachment if provided
                    if ($fields->attachment) {
                        $fileUploadService = app(FileUploadService::class);
                        $attachment = $fileUploadService->uploadTicketAttachment($fields->attachment, $ticket->id);

                        // Add attachment to response
                        $response->update(['attachments' => [$attachment]]);
                    }

                    $responsesAdded++;
                } catch (\Exception $e) {
                    $errors[] = "Ticket #{$ticket->ticket_number}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some responses failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully added response to {$responsesAdded} ticket(s).");
    }



    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make('Your Reply', 'message')
                ->rules('required', 'min:5', 'max:1000')
                ->rows(4)
                ->placeholder('Type your reply here...')
                ->help('Enter your response (5-1000 characters)'),

            File::make('Attach File', 'attachment')
                ->disk('public')
                ->path('ticket-attachments')
                ->acceptedTypes('.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip')
                ->help('Optional: Attach a file (Max 10MB)')
                ->nullable(),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        // Only show to authenticated customer users
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Determine if the action can be run for the given request.
     */
    public function authorizedToRun(\Illuminate\Http\Request $request, $model)
    {
        $user = $request->user();

        // Must be a customer
        if (!$user || !$user->isCustomer()) {
            return false;
        }

        // Must be a ticket
        if (!$model instanceof \App\Models\Ticket) {
            return false;
        }

        // Customer must own the ticket
        return $model->customer_id === $user->userable_id;
    }


}
