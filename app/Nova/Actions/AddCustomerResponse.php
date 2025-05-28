<?php

namespace App\Nova\Actions;

use App\Models\Ticket;
use App\Services\TicketService;
use App\Services\FileUploadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
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
    public $name = 'Add Response & Attachment';

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
                    if (!$user->isCustomer() || $ticket->customer_id !== $user->userable->id) {
                        $errors[] = "Ticket #{$ticket->ticket_number}: Access denied";
                        continue;
                    }

                    // Handle file attachments if provided
                    $attachments = [];
                    if ($fields->attachment) {
                        $fileUploadService = app(FileUploadService::class);
                        $attachments[] = $fileUploadService->uploadTicketAttachment($fields->attachment, $ticket->id);
                    }

                    // Add customer response using service
                    $response = $ticketService->addCustomerResponse(
                        $ticket,
                        $user,
                        $fields->message
                    );

                    // Update response with attachments if any
                    if (!empty($attachments)) {
                        $response->update(['attachments' => $attachments]);
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
            Textarea::make('Message')
                ->rules('required', 'min:10', 'max:1000')
                ->rows(5)
                ->help('Enter your response message (10-1000 characters)'),

            File::make('Attachment')
                ->disk('public')
                ->path('ticket-attachments')
                ->acceptedTypes('.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip')
                ->help('Optional: Upload a file (Images, Documents, Archives - Max 10MB)')
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
}
