<?php

namespace App\Nova;

use App\Models\TicketResponse as TicketResponseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class TicketResponse extends Resource
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
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Support Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'message',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Ticket Responses';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Ticket Response';
    }

    /**
     * Determine if the current user can view any resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Use policy for authorization
        return $user->can('viewAny', \App\Models\TicketResponse::class);
    }

    /**
     * Determine if the current user can view the resource.
     */
    public function authorizedToView(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Use policy for authorization
        return $user->can('view', $this->resource);
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Use policy for authorization
        return $user->can('create', \App\Models\TicketResponse::class);
    }

    /**
     * Determine if the current user can update the given resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Use policy for authorization
        return $user->can('update', $this->resource);
    }

    /**
     * Determine if the current user can delete the given resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        // Use policy for authorization
        return $user->can('delete', $this->resource);
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->with(['ticket', 'user', 'adminUser']);

        // Filter for customers to only show responses to their own tickets
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Ticket')
                ->sortable()
                ->searchable(),

            Badge::make('Type')
                ->map([
                    TicketResponseModel::TYPE_CUSTOMER => 'info',
                    TicketResponseModel::TYPE_STAFF => 'success',
                    TicketResponseModel::TYPE_INTERNAL => 'warning',
                ])
                ->labels([
                    TicketResponseModel::TYPE_CUSTOMER => 'Customer',
                    TicketResponseModel::TYPE_STAFF => 'Staff',
                    TicketResponseModel::TYPE_INTERNAL => 'Internal',
                ])
                ->sortable(),

            Select::make('Type')
                ->options([
                    TicketResponseModel::TYPE_CUSTOMER => 'Customer',
                    TicketResponseModel::TYPE_STAFF => 'Staff',
                    TicketResponseModel::TYPE_INTERNAL => 'Internal',
                ])
                ->default(TicketResponseModel::TYPE_STAFF)
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Author', function () {
                return $this->author_name;
            })
                ->onlyOnIndex(),

            BelongsTo::make('Customer User', 'user', User::class)
                ->nullable()
                ->hideFromIndex()
                ->searchable(),

            BelongsTo::make('Staff Member', 'adminUser', AdminUser::class)
                ->nullable()
                ->hideFromIndex()
                ->searchable(),

            Textarea::make('Message')
                ->rules('required')
                ->rows(4),

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

            Text::make('Customer Files', function () {
                // Cache the result to avoid repeated processing
                static $fileCache = [];
                $cacheKey = "response_{$this->id}_files";

                if (isset($fileCache[$cacheKey])) {
                    return $fileCache[$cacheKey];
                }

                if (!$this->attachments || !is_array($this->attachments) || empty($this->attachments)) {
                    $result = '<span class="text-gray-500">No files attached by customer</span>';
                    $fileCache[$cacheKey] = $result;
                    return $result;
                }

                $attachmentList = [];
                foreach ($this->attachments as $index => $attachment) {
                    $name = $attachment['original_name'] ?? 'Unknown';
                    $size = isset($attachment['file_size']) ?
                        \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';
                    $downloadUrl = $attachment['download_url'] ?? '#';
                    $uploadedAt = $attachment['uploaded_at'] ?? 'Unknown';

                    // Use admin download route for better control
                    $adminDownloadUrl = "/admin/download-attachment/{$this->id}/{$index}";

                    $attachmentList[] = "<div class='border border-gray-200 rounded-lg p-3 mb-3 bg-gray-50'>" .
                                      "<div class='flex items-center justify-between mb-2'>" .
                                      "<div class='flex items-center'>" .
                                      "<span class='text-blue-500 mr-2'>📎</span>" .
                                      "<a href='{$adminDownloadUrl}' target='_blank' class='text-blue-600 hover:text-blue-800 font-medium text-sm'>{$name}</a>" .
                                      "</div>" .
                                      ($size ? "<span class='text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded'>{$size}</span>" : '') .
                                      "</div>" .
                                      "<div class='flex items-center justify-between'>" .
                                      "<div class='text-xs text-gray-500'>Uploaded: {$uploadedAt}</div>" .
                                      "<a href='{$adminDownloadUrl}' target='_blank' class='text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200'>Download</a>" .
                                      "</div>" .
                                      "</div>";
                }

                $result = "<div class='space-y-2'>" . implode('', $attachmentList) . "</div>";
                $fileCache[$cacheKey] = $result;
                return $result;
            })
                ->onlyOnDetail()
                ->asHtml(),

            Boolean::make('Internal Note', 'is_internal')
                ->help('Internal notes are only visible to staff members'),

            Number::make('Response Time (Minutes)', 'response_time_minutes')
                ->nullable()
                ->hideFromIndex()
                ->help('Time taken to respond in minutes'),

            DateTime::make('Created At')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At')
                ->onlyOnDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            \App\Nova\Actions\AdminAddAttachment::make(),
            \App\Nova\Actions\AdminRemoveAttachment::make(),
        ];
    }
}
