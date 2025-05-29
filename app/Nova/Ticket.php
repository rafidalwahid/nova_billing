<?php

namespace App\Nova;

use App\Models\Ticket as TicketModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class Ticket extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Ticket>
     */
    public static $model = \App\Models\Ticket::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'formatted_ticket_number';

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
        'id', 'ticket_number', 'subject', 'description',
    ];

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->with(['customer', 'department', 'assignedTo']);

        // Apply customer data isolation using base class method
        return static::applyCustomerDataIsolation($request, $query, 'customer_id');
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->with([
            'customer',
            'department',
            'assignedTo',
            'responses' => function ($query) {
                $query->where('type', \App\Models\TicketResponse::TYPE_CUSTOMER)
                      ->whereNotNull('attachments')
                      ->where('attachments', '!=', '[]');
            }
        ]);
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
        return $user->can('viewAny', \App\Models\Ticket::class);
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
        return $user->can('create', \App\Models\Ticket::class);
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Support Tickets';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Support Ticket';
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

            Text::make('Ticket Number')
                ->displayUsing(function ($value) {
                    return $this->formatted_ticket_number;
                })
                ->onlyOnIndex()
                ->sortable(),

            Text::make('Ticket Number', 'ticket_number')
                ->hideFromIndex()
                ->readonly()
                ->help('Auto-generated when ticket is created'),

            BelongsTo::make('Customer')
                ->sortable()
                ->searchable()
                ->showCreateRelationButton()
                ->display(function ($customer) {
                    return $customer->first_name . ' ' . $customer->last_name;
                }),

            Text::make('Subject')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make('Description')
                ->hideFromIndex()
                ->rules('required')
                ->rows(4),

            Badge::make('Status')
                ->map([
                    TicketModel::STATUS_OPEN => 'info',
                    TicketModel::STATUS_IN_PROGRESS => 'warning',
                    TicketModel::STATUS_RESOLVED => 'success',
                    TicketModel::STATUS_CLOSED => 'danger',
                ])
                ->labels([
                    TicketModel::STATUS_OPEN => 'Open',
                    TicketModel::STATUS_IN_PROGRESS => 'In Progress',
                    TicketModel::STATUS_RESOLVED => 'Resolved',
                    TicketModel::STATUS_CLOSED => 'Closed',
                ])
                ->sortable(),

            Select::make('Status')
                ->options(TicketModel::getStatuses())
                ->default(TicketModel::STATUS_OPEN)
                ->rules('required')
                ->hideFromIndex(),

            Badge::make('Priority')
                ->map([
                    TicketModel::PRIORITY_LOW => 'info',
                    TicketModel::PRIORITY_NORMAL => 'success',
                    TicketModel::PRIORITY_HIGH => 'warning',
                    TicketModel::PRIORITY_URGENT => 'danger',
                ])
                ->labels([
                    TicketModel::PRIORITY_LOW => 'Low',
                    TicketModel::PRIORITY_NORMAL => 'Normal',
                    TicketModel::PRIORITY_HIGH => 'High',
                    TicketModel::PRIORITY_URGENT => 'Urgent',
                ])
                ->sortable(),

            Select::make('Priority')
                ->options(TicketModel::getPriorities())
                ->default(TicketModel::PRIORITY_NORMAL)
                ->rules('required')
                ->hideFromIndex(),

            Badge::make('Category')
                ->map([
                    TicketModel::CATEGORY_BILLING => 'success',
                    TicketModel::CATEGORY_TECHNICAL => 'info',
                    TicketModel::CATEGORY_SALES => 'warning',
                    TicketModel::CATEGORY_GENERAL => 'info',
                ])
                ->labels([
                    TicketModel::CATEGORY_BILLING => 'Billing',
                    TicketModel::CATEGORY_TECHNICAL => 'Technical',
                    TicketModel::CATEGORY_SALES => 'Sales',
                    TicketModel::CATEGORY_GENERAL => 'General',
                ])
                ->sortable(),

            Select::make('Category')
                ->options(TicketModel::getCategories())
                ->default(TicketModel::CATEGORY_GENERAL)
                ->rules('required')
                ->hideFromIndex(),

            BelongsTo::make('Assigned To', 'assignedTo', AdminUser::class)
                ->nullable()
                ->searchable()
                ->showCreateRelationButton(),

            BelongsTo::make('Department')
                ->nullable()
                ->searchable()
                ->showCreateRelationButton(),

            Text::make('Source')
                ->default('web')
                ->hideFromIndex()
                ->rules('required'),

            DateTime::make('Created At')
                ->onlyOnDetail()
                ->sortable(),

            DateTime::make('Updated At')
                ->onlyOnDetail()
                ->sortable(),

            DateTime::make('Resolved At')
                ->hideFromIndex()
                ->nullable(),

            DateTime::make('Closed At')
                ->hideFromIndex()
                ->nullable(),

            Text::make('SLA Due At', function () {
                if (!$this->sla_due_at) return null;

                $dueAt = $this->sla_due_at;
                $isOverdue = $dueAt->isPast() && !in_array($this->status, [TicketModel::STATUS_RESOLVED, TicketModel::STATUS_CLOSED]);

                if ($isOverdue) {
                    return $dueAt->format('M j, Y g:i A') . ' (OVERDUE)';
                }

                return $dueAt->format('M j, Y g:i A');
            })
                ->sortable()
                ->displayUsing(function ($value) {
                    if (!$value) return null;

                    if (strpos($value, 'OVERDUE') !== false) {
                        return '<span class="text-red-600 font-semibold">' . $value . '</span>';
                    }

                    return $value;
                })
                ->asHtml(),

            DateTime::make('SLA Due At', 'sla_due_at')
                ->hideFromIndex()
                ->nullable(),

            Text::make('Response Time', function () {
                $minutes = $this->getResponseTimeMinutes();
                if ($minutes === null) {
                    return 'No response yet';
                }

                $hours = floor($minutes / 60);
                $mins = $minutes % 60;

                if ($hours > 0) {
                    return "{$hours}h {$mins}m";
                } else {
                    return "{$mins}m";
                }
            })
                ->onlyOnDetail()
                ->displayUsing(function ($value) {
                    if ($value === 'No response yet') {
                        return '<span class="text-yellow-600">' . $value . '</span>';
                    }
                    return '<span class="text-green-600">' . $value . '</span>';
                })
                ->asHtml(),

            Text::make('Customer Attachments', function () {
                // Only load this on detail view and cache the result
                static $attachmentCache = [];
                $cacheKey = "ticket_{$this->id}_attachments";

                if (isset($attachmentCache[$cacheKey])) {
                    return $attachmentCache[$cacheKey];
                }

                // Use a more efficient query to get customer responses with attachments
                $customerResponses = $this->responses()
                    ->where('type', \App\Models\TicketResponse::TYPE_CUSTOMER)
                    ->whereNotNull('attachments')
                    ->where('attachments', '!=', '[]')
                    ->get();

                $totalAttachments = 0;
                $attachmentFiles = [];

                foreach ($customerResponses as $response) {
                    if ($response->attachments && is_array($response->attachments)) {
                        $totalAttachments += count($response->attachments);
                        foreach ($response->attachments as $index => $attachment) {
                            $name = $attachment['original_name'] ?? 'Unknown';
                            $size = isset($attachment['file_size']) ?
                                \App\Services\FileUploadService::formatFileSize($attachment['file_size']) : '';

                            // Use admin download route for better control
                            $adminDownloadUrl = "/admin/download-attachment/{$response->id}/{$index}";

                            $attachmentFiles[] = "<div class='flex items-center justify-between py-1 border-b border-gray-100'>" .
                                               "<div class='flex items-center'>" .
                                               "<span class='text-blue-500 mr-2'>📎</span>" .
                                               "<a href='{$adminDownloadUrl}' target='_blank' class='text-blue-600 hover:text-blue-800 font-medium'>{$name}</a>" .
                                               ($size ? " <span class='text-gray-500 ml-2'>({$size})</span>" : '') .
                                               "</div>" .
                                               "<a href='{$adminDownloadUrl}' target='_blank' class='text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200'>Download</a>" .
                                               "</div>";
                        }
                    }
                }

                $result = $totalAttachments === 0
                    ? '<span class="text-gray-500">No customer attachments</span>'
                    : "<div class='mb-3'><strong class='text-gray-700'>📎 {$totalAttachments} file(s) from customer:</strong></div>" .
                      "<div class='bg-gray-50 border border-gray-200 rounded-lg p-3'>" . implode('', $attachmentFiles) . "</div>";

                $attachmentCache[$cacheKey] = $result;
                return $result;
            })
                ->onlyOnDetail()
                ->asHtml(),

            Textarea::make('Internal Notes')
                ->hideFromIndex()
                ->rows(3),

            HasMany::make('Responses', 'responses', TicketResponse::class),
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
        return [
            new \App\Nova\Metrics\TicketMetrics,
            new \App\Nova\Metrics\OverdueTickets,
            new \App\Nova\Metrics\TicketsByStatus,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new \App\Nova\Filters\TicketStatus,
            new \App\Nova\Filters\TicketPriority,
            new \App\Nova\Filters\TicketCategory,
            new \App\Nova\Filters\AssignedToMe,
            new \App\Nova\Filters\OverdueTickets,
        ];
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
        $user = $request->user();

        // Customer actions
        if ($user && $user->isCustomer()) {
            return [
                \App\Nova\Actions\AddCustomerResponse::make(),
            ];
        }

        // Staff actions
        return [
            \App\Nova\Actions\AssignToSelf::make(),
            \App\Nova\Actions\ReassignTicket::make(),
            \App\Nova\Actions\ChangeTicketStatus::make(),
            \App\Nova\Actions\EscalateTicket::make(),
            \App\Nova\Actions\AddTicketResponse::make(),
        ];
    }
}
