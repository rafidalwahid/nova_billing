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

    // Authorization methods removed - using base Resource class authorization with policies

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->with(['ticket', 'user', 'adminUser']);

        // Apply customer data isolation for responses through ticket relationship
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

            Text::make('Attached Files', function () use ($request) {
                // Cache the result to avoid repeated processing
                static $fileCache = [];
                $user = $request->user();
                $isCustomer = $user && $user->isCustomer();
                $cacheKey = "response_{$this->id}_files_" . ($isCustomer ? 'customer' : 'admin');

                if (isset($fileCache[$cacheKey])) {
                    return $fileCache[$cacheKey];
                }

                if (!$this->attachments || !is_array($this->attachments) || empty($this->attachments)) {
                    $result = '<span class="text-gray-500">No files attached</span>';
                    $fileCache[$cacheKey] = $result;
                    return $result;
                }

                $attachmentList = [];
                foreach ($this->attachments as $index => $attachment) {
                    $name = $attachment['original_name'] ?? 'Unknown';
                    $size = isset($attachment['file_size']) ?
                        \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';
                    $uploadedAt = $attachment['uploaded_at'] ?? 'Unknown';

                    if ($isCustomer) {
                        // Customer view - simpler display with public download links
                        $publicDownloadUrl = $attachment['download_url'] ?? '#';
                        $attachmentList[] = "<div class='border border-gray-200 rounded-lg p-3 mb-2 bg-blue-50'>" .
                                          "<div class='flex items-center justify-between'>" .
                                          "<div class='flex items-center'>" .
                                          "<span class='text-blue-500 mr-2'>📎</span>" .
                                          "<span class='text-gray-800 font-medium text-sm'>{$name}</span>" .
                                          ($size ? "<span class='text-xs text-gray-500 ml-2'>({$size})</span>" : '') .
                                          "</div>" .
                                          "<a href='{$publicDownloadUrl}' target='_blank' class='text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200'>Download</a>" .
                                          "</div>" .
                                          "</div>";
                    } else {
                        // Admin view - detailed display with admin download route
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
        $user = $request->user();

        // Basic filters for all users
        $filters = [
            new \App\Nova\Filters\ResponseType,
        ];

        // Add admin-only filters
        if ($user && $user->isAdmin()) {
            $filters[] = new \App\Nova\Filters\ResponseWithAttachments;
        }

        return $filters;
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
        // No actions needed - responses are managed through the ticket
        return [];
    }
}
