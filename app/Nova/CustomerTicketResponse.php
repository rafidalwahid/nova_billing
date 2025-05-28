<?php

namespace App\Nova;

use App\Models\TicketResponse as TicketResponseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerTicketResponse extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TicketResponse>
     */
    public static $model = \App\Models\TicketResponse::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return 'My Ticket Responses';
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return 'Ticket Response';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Customer Portal';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'message',
    ];

    /**
     * Determine if the current user can view any resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Determine if the current user can view the resource.
     */
    public function authorizedToView(Request $request): bool
    {
        $user = $request->user();

        if (!$user || !$user->isCustomer()) {
            return false;
        }

        // Customers can only view responses to their own tickets
        return $this->resource->ticket &&
               $this->resource->ticket->customer_id === $user->userable->id;
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        // Customers should create responses through the ticket action, not directly
        return false;
    }

    /**
     * Determine if the current user can update the resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        $user = $request->user();

        if (!$user || !$user->isCustomer()) {
            return false;
        }

        // Only allow editing customer's own responses
        if ($this->resource->type !== TicketResponseModel::TYPE_CUSTOMER) {
            return false;
        }

        // Only allow editing if response belongs to customer's ticket
        if (!$this->resource->ticket || $this->resource->ticket->customer_id !== $user->userable->id) {
            return false;
        }

        // Allow editing anytime for customer responses
        return true;
    }

    /**
     * Determine if the current user can delete the resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        // Customers cannot delete responses
        return false;
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->with(['ticket', 'user', 'adminUser']);

        // Filter to only show responses to customer's own tickets
        $user = $request->user();
        if ($user && $user->isCustomer()) {
            $query->whereHas('ticket', function ($ticketQuery) use ($user) {
                $ticketQuery->where('customer_id', $user->userable->id);
            });
        }

        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return static::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable()->hideFromIndex(),

            BelongsTo::make('Ticket')
                ->sortable()
                ->searchable()
                ->displayUsing(function ($ticket) {
                    return $ticket->formatted_ticket_number ?? 'N/A';
                }),

            Badge::make('Type')
                ->map([
                    TicketResponseModel::TYPE_CUSTOMER => 'info',
                    TicketResponseModel::TYPE_STAFF => 'success',
                    TicketResponseModel::TYPE_INTERNAL => 'warning',
                ])
                ->labels([
                    TicketResponseModel::TYPE_CUSTOMER => 'My Response',
                    TicketResponseModel::TYPE_STAFF => 'Staff Response',
                    TicketResponseModel::TYPE_INTERNAL => 'Internal Note',
                ])
                ->sortable(),

            Text::make('Author', function () {
                if ($this->type === TicketResponseModel::TYPE_CUSTOMER) {
                    return 'You';
                }
                return $this->author_name ?? 'Staff Member';
            })
                ->onlyOnIndex(),

            Textarea::make('Message')
                ->hideFromIndex()
                ->rules('required', 'min:10', 'max:1000')
                ->rows(4)
                ->help('Edit your response message anytime (10-1000 characters)')
                ->readonly(function ($request) {
                    // Only allow editing customer's own responses
                    return $this->resource->type !== TicketResponseModel::TYPE_CUSTOMER;
                }),

            Text::make('Attachments', function () {
                if ($this->attachments && is_array($this->attachments)) {
                    $count = count($this->attachments);
                    if ($count === 1) {
                        $attachment = $this->attachments[0];
                        $name = $attachment['original_name'] ?? 'Unknown';
                        $size = isset($attachment['file_size']) ?
                            \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';
                        return $name . ($size ? " ({$size})" : '');
                    } else {
                        return "{$count} files attached";
                    }
                }
                return 'No attachments';
            })
                ->onlyOnIndex(),

            Text::make('Files', function () {
                if ($this->attachments && is_array($this->attachments)) {
                    $attachmentList = [];
                    foreach ($this->attachments as $index => $attachment) {
                        $name = $attachment['original_name'] ?? 'Unknown';
                        $size = isset($attachment['file_size']) ?
                            \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';
                        $downloadUrl = $attachment['download_url'] ?? '#';

                        // Create remove URL for this specific attachment
                        $removeUrl = "/customer/remove-attachment/{$this->id}/{$index}";

                        $attachmentList[] = "<div class='flex items-center justify-between py-1'>" .
                                          "<div>" .
                                          "<a href='{$downloadUrl}' target='_blank' class='text-blue-600 hover:text-blue-800'>{$name}</a>" .
                                          ($size ? " <span class='text-gray-500'>({$size})</span>" : '') .
                                          "</div>" .
                                          "<a href='{$removeUrl}' onclick='return confirm(\"Remove {$name}?\")' class='text-red-600 hover:text-red-800 text-sm ml-4'>Remove</a>" .
                                          "</div>";
                    }
                    return implode('', $attachmentList);
                }
                return '<span class="text-gray-500">No files attached</span>';
            })
                ->onlyOnDetail()
                ->asHtml(),

            Text::make('Current Attachments', function () {
                if ($this->attachments && is_array($this->attachments)) {
                    $attachmentList = [];
                    foreach ($this->attachments as $index => $attachment) {
                        $name = $attachment['original_name'] ?? 'Unknown';
                        $size = isset($attachment['file_size']) ?
                            \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';
                        $downloadUrl = $attachment['download_url'] ?? '#';
                        $attachmentList[] = "<a href='{$downloadUrl}' target='_blank' class='text-blue-600 hover:text-blue-800'>{$name}</a>" .
                                          ($size ? " <span class='text-gray-500'>({$size})</span>" : '');
                    }
                    return implode('<br>', $attachmentList);
                }
                return '<span class="text-gray-500">No attachments</span>';
            })
                ->onlyOnForms()
                ->asHtml()
                ->help('Current files attached to this response'),

            Text::make('Attachment Actions', function () {
                return '🔧 <strong>Manage Attachments:</strong><br>' .
                       '• Use <strong>"Add File Attachment"</strong> action to upload new files<br>' .
                       '• Use <strong>"Remove Attachment"</strong> action to delete files<br>' .
                       '• Actions are available in the dropdown menu above<br>' .
                       '• You can edit your message and manage attachments separately';
            })
                ->onlyOnForms()
                ->asHtml()
                ->help('Use the action buttons above to manage attachments'),

            Text::make('Edit Status', function () {
                if ($this->type !== TicketResponseModel::TYPE_CUSTOMER) {
                    return '<span class="text-blue-600">Staff Response</span>';
                }

                return '<span class="text-green-600">✓ Editable anytime</span>';
            })
                ->onlyOnDetail()
                ->asHtml(),

            DateTime::make('Created At')
                ->sortable()
                ->readonly()
                ->displayUsing(function ($value) {
                    return $value ? $value->format('M j, Y g:i A') : 'N/A';
                })
                ->help('Response creation timestamp'),
        ];
    }



    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [
            \App\Nova\Actions\AddAttachmentToResponse::make(),
        ];
    }


}
