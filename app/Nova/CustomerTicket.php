<?php

namespace App\Nova;

use App\Models\Ticket as TicketModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerTicket extends Resource
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
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return 'My Support Tickets';
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return 'Support Ticket';
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
        'id', 'ticket_number', 'subject', 'description',
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

        // Customers can only view their own tickets
        return $this->resource->customer_id === $user->userable->id;
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Determine if the current user can update the given resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        // Customers cannot update tickets after creation
        return false;
    }

    /**
     * Determine if the current user can delete the given resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        // Customers cannot delete tickets
        return false;
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->with(['customer', 'department', 'assignedTo', 'responses']);

        // Filter to only show customer's own tickets
        $user = $request->user();
        if ($user && $user->isCustomer()) {
            $query->where('customer_id', $user->userable->id);
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
        $user = $request->user();
        $isCreating = $request->isCreateOrAttachRequest();

        return [
            ID::make()->sortable()->hideFromIndex(),

            Text::make('Ticket Number')
                ->displayUsing(function ($value) {
                    return $this->formatted_ticket_number;
                })
                ->onlyOnIndex()
                ->sortable(),

            Text::make('Subject')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Brief description of your issue'),

            Textarea::make('Description')
                ->hideFromIndex()
                ->rules('required', 'min:20', 'max:1000')
                ->rows(4)
                ->help('Please provide detailed information about your issue'),

            Select::make('Category')
                ->options([
                    TicketModel::CATEGORY_BILLING => 'Billing & Payments',
                    TicketModel::CATEGORY_TECHNICAL => 'Technical Support',
                    TicketModel::CATEGORY_GENERAL => 'General Inquiry',
                    TicketModel::CATEGORY_SALES => 'Sales Question',
                ])
                ->default(TicketModel::CATEGORY_GENERAL)
                ->rules('required')
                ->displayUsingLabels()
                ->help('Select the category that best describes your issue'),

            Select::make('Priority')
                ->options([
                    TicketModel::PRIORITY_LOW => 'Low - General question',
                    TicketModel::PRIORITY_NORMAL => 'Normal - Standard issue',
                    TicketModel::PRIORITY_HIGH => 'High - Service affecting',
                ])
                ->default(TicketModel::PRIORITY_NORMAL)
                ->rules('required')
                ->displayUsingLabels()
                ->help('How urgent is this issue?')
                ->showOnCreating()
                ->showOnUpdating(),

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
                ->sortable()
                ->hideWhenCreating(),

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
                ->sortable()
                ->hideWhenCreating(),

            DateTime::make('Created At')
                ->onlyOnDetail()
                ->sortable(),

            DateTime::make('Last Updated', 'updated_at')
                ->onlyOnIndex()
                ->sortable(),

            Text::make('Response Time', function () {
                $minutes = $this->getResponseTimeMinutes();
                if ($minutes === null) {
                    return 'Awaiting response';
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
                    if ($value === 'Awaiting response') {
                        return '<span class="text-yellow-600">' . $value . '</span>';
                    }
                    return '<span class="text-green-600">' . $value . '</span>';
                })
                ->asHtml(),

            HasMany::make('Responses', 'responses', TicketResponse::class),
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
     * Handle resource creation - automatically set customer_id.
     */
    public static function fill(NovaRequest $request, $model): array
    {
        $fields = parent::fill($request, $model);

        // Automatically set the customer_id when creating a ticket
        if ($request->isCreateOrAttachRequest()) {
            $user = $request->user();
            if ($user && $user->isCustomer()) {
                $model->customer_id = $user->userable->id;
                $model->source = 'web';
                $model->status = TicketModel::STATUS_OPEN;

                // Set email from user if not provided
                if (!$model->email) {
                    $model->email = $user->email;
                }
            }
        }

        return $fields;
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new \App\Nova\Filters\TicketStatus,
            new \App\Nova\Filters\TicketPriority,
            new \App\Nova\Filters\TicketCategory,
        ];
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
            \App\Nova\Actions\AddCustomerResponse::make(),
        ];
    }
}
