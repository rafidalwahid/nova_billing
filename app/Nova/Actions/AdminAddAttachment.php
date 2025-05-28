<?php

namespace App\Nova\Actions;

use App\Models\TicketResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class AdminAddAttachment extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     */
    public $name = 'Add Attachment (Admin)';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $user = request()->user();
        $attachmentsAdded = 0;
        $errors = [];

        foreach ($models as $response) {
            if ($response instanceof TicketResponse) {
                try {
                    // Verify user is admin/staff
                    if (!$user->isAdmin()) {
                        $errors[] = "Response #{$response->id}: Access denied - admin only";
                        continue;
                    }

                    // Handle file upload
                    if (!$fields->attachment) {
                        $errors[] = "Response #{$response->id}: No file provided";
                        continue;
                    }

                    $fileUploadService = app(\App\Services\FileUploadService::class);
                    $newAttachment = $fileUploadService->uploadTicketAttachment(
                        $fields->attachment,
                        $response->ticket_id
                    );

                    // Add to existing attachments
                    $existingAttachments = $response->attachments ?? [];
                    $existingAttachments[] = $newAttachment;

                    $response->update(['attachments' => $existingAttachments]);
                    $attachmentsAdded++;

                } catch (\Exception $e) {
                    $errors[] = "Response #{$response->id}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some uploads failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully added {$attachmentsAdded} attachment(s).");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            File::make('Attachment')
                ->disk('public')
                ->path('ticket-attachments')
                ->acceptedTypes('.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip')
                ->help('Upload a file to attach to this response (Max 10MB)')
                ->rules('required'),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        // Only show to authenticated admin users
        $user = $request->user();
        return $user && $user->isAdmin();
    }
}
