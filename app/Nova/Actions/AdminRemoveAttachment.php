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
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AdminRemoveAttachment extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * The displayable name of the action.
     */
    public $name = 'Remove Attachment (Admin)';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $user = request()->user();
        $attachmentsRemoved = 0;
        $errors = [];

        foreach ($models as $response) {
            if ($response instanceof TicketResponse) {
                try {
                    // Verify user is admin/staff
                    if (!$user->isAdmin()) {
                        $errors[] = "Response #{$response->id}: Access denied - admin only";
                        continue;
                    }

                    // Check if response has attachments
                    if (!$response->attachments || !is_array($response->attachments)) {
                        $errors[] = "Response #{$response->id}: No attachments found";
                        continue;
                    }

                    // Parse the selected attachment (format: "filename.ext")
                    $selectedFileName = $fields->attachment_to_remove;
                    $attachmentIndex = null;

                    // Find the attachment by filename
                    foreach ($response->attachments as $index => $attachment) {
                        if (($attachment['original_name'] ?? '') === $selectedFileName) {
                            $attachmentIndex = $index;
                            break;
                        }
                    }

                    if ($attachmentIndex === null) {
                        $errors[] = "Response #{$response->id}: Attachment '{$selectedFileName}' not found";
                        continue;
                    }

                    // Remove the attachment from the array
                    $attachments = $response->attachments;
                    $removedAttachment = $attachments[$attachmentIndex];
                    unset($attachments[$attachmentIndex]);

                    // Reindex the array
                    $attachments = array_values($attachments);

                    // Update the response
                    $response->update(['attachments' => $attachments]);
                    $attachmentsRemoved++;

                    // Optionally delete the physical file
                    if (isset($removedAttachment['file_path'])) {
                        $fileUploadService = app(\App\Services\FileUploadService::class);
                        $fileUploadService->deleteTicketAttachment($removedAttachment['file_path']);
                    }

                } catch (\Exception $e) {
                    $errors[] = "Response #{$response->id}: " . $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return Action::danger('Some removals failed: ' . implode('; ', $errors));
        }

        return Action::message("Successfully removed {$attachmentsRemoved} attachment(s).");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Attachment to Remove', 'attachment_to_remove')
                ->rules('required')
                ->help('Enter the exact filename to remove (e.g., "screenshot.png"). Check the response detail view to see current attachments.'),
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
