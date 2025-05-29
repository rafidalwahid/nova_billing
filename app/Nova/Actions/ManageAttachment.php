<?php

namespace App\Nova\Actions;

use App\Services\AttachmentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ManageAttachment extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Manage Attachments';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $user = request()->user();
        $attachmentService = app(AttachmentService::class);
        $errors = [];
        $successes = [];

        foreach ($models as $response) {
            try {
                if ($fields->action_type === 'add' && $fields->attachment) {
                    // Add attachment
                    $attachmentData = $attachmentService->addAttachment(
                        $response,
                        $fields->attachment,
                        $user
                    );
                    $successes[] = "Added attachment '{$attachmentData['original_name']}' to response #{$response->id}";

                } elseif ($fields->action_type === 'remove' && $fields->filename_to_remove) {
                    // Validate that it's not a placeholder value
                    if (in_array($fields->filename_to_remove, ['no_files', 'no_response', 'no_selection'])) {
                        $errors[] = "Response #{$response->id}: Please select a valid attachment to remove";
                        continue;
                    }

                    // Remove attachment
                    $attachmentService->removeAttachment(
                        $response,
                        $fields->filename_to_remove,
                        $user
                    );
                    $successes[] = "Removed attachment '{$fields->filename_to_remove}' from response #{$response->id}";
                }

            } catch (\Exception $e) {
                $errors[] = "Response #{$response->id}: " . $e->getMessage();
            }
        }

        // Return results
        if (!empty($errors)) {
            return Action::danger('Some operations failed: ' . implode('; ', $errors));
        }

        if (!empty($successes)) {
            return Action::message(implode('; ', $successes));
        }

        return Action::message('No action performed. Please select an action type and provide required fields.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Action Type', 'action_type')
                ->options([
                    'add' => 'Add Attachment',
                    'remove' => 'Remove Attachment',
                ])
                ->rules('required')
                ->help('Choose whether to add or remove an attachment'),

            File::make('Attachment')
                ->disk('public')
                ->path('ticket-attachments')
                ->acceptedTypes('.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip')
                ->help('Upload a file (Images, Documents, Archives - Max 10MB)')
                ->dependsOn(['action_type'], function (File $field, NovaRequest $request, $formData) {
                    if ($formData['action_type'] === 'add') {
                        $field->show()->rules('required');
                    } else {
                        $field->hide();
                    }
                }),

            Select::make('File to Remove', 'filename_to_remove')
                ->help('Select the file you want to remove')
                ->dependsOn(['action_type'], function (Select $field, NovaRequest $request, $formData) {
                    if ($formData['action_type'] === 'remove') {
                        $field->show()->rules('required');

                        // Get the first selected model to show available attachments
                        $resourceIds = $request->get('resources', []);

                        // Handle both string and array formats
                        if (is_string($resourceIds)) {
                            $resourceIds = explode(',', $resourceIds);
                        }

                        if (!empty($resourceIds) && is_array($resourceIds)) {
                            $firstId = $resourceIds[0];
                            $response = \App\Models\TicketResponse::find($firstId);

                            if ($response) {
                                $attachmentService = app(AttachmentService::class);
                                $options = $attachmentService->getAvailableAttachments($response);

                                if (empty($options)) {
                                    $field->options(['no_files' => 'No attachments available'])
                                         ->help('This response has no attachments to remove');
                                } else {
                                    $field->options($options);
                                }
                            } else {
                                $field->options(['no_response' => 'Response not found'])
                                     ->help('Unable to load response data');
                            }
                        } else {
                            $field->options(['no_selection' => 'No response selected'])
                                 ->help('Please select a response first');
                        }
                    } else {
                        $field->hide();
                    }
                }),
        ];
    }

    /**
     * Determine if the action is executable for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToSee(\Illuminate\Http\Request $request)
    {
        $user = $request->user();

        // Only staff can use this action
        return $user && !$user->isCustomer();
    }

    /**
     * Determine if the action is authorized to run for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function authorizedToRun(\Illuminate\Http\Request $request, $model)
    {
        $user = $request->user();

        // Staff can manage attachments on any response they can update
        return $user && !$user->isCustomer() && $user->can('update', $model);
    }
}
