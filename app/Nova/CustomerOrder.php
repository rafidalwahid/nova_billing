<?php

namespace App\Nova;

use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CustomerOrder extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<Order>
     */
    public static $model = Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'formatted_order_number';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Customer Portal';

    /**
     * The icon of the resource.
     *
     * @var string
     */
    public static $icon = 'shopping-bag';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'order_number',
    ];

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return 'My Orders';
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return 'Order';
    }

    /**
     * Determine if this resource is available for navigation.
     */
    public static function availableForNavigation(Request $request): bool
    {
        return self::isCustomerUser($request);
    }

    /**
     * Determine if the current user can view any resources.
     */
    public static function authorizedToViewAny(Request $request): bool
    {
        return self::isCustomerUser($request);
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

        // Customers can only view their own orders
        if ($user->isCustomer()) {
            return $this->isCustomerOrder($user);
        }

        // Staff users can view all orders (if they have permission)
        return true;
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            $this->idField(),
            $this->orderNumberField(),
            $this->statusField(),
            $this->totalField(),
            $this->orderDateField(),
            $this->orderItemsField(),
            $this->invoiceField(),
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
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::applyCustomerFilter($request, $query->with(['customer', 'items', 'invoice']));
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::applyCustomerFilter($request, $query->with(['customer', 'items.product', 'invoice']));
    }

    /**
     * Build a "relatable" query for the given resource.
     */
    public static function relatableQuery(NovaRequest $request, Builder $query): Builder
    {
        return self::indexQuery($request, $query);
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate(Request $request): bool
    {
        return false; // Customers cannot create orders through Nova
    }

    /**
     * Determine if the current user can update the given resource.
     */
    public function authorizedToUpdate(Request $request): bool
    {
        return false; // Customers cannot update orders
    }

    /**
     * Determine if the current user can delete the given resource.
     */
    public function authorizedToDelete(Request $request): bool
    {
        return false; // Customers cannot delete orders
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new \App\Nova\Filters\CustomerOrderStatus,
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
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Check if the current user is a customer.
     */
    private static function isCustomerUser(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->isCustomer();
    }

    /**
     * Check if the order belongs to the current customer.
     */
    private function isCustomerOrder($user): bool
    {
        return $this->resource->customer_id === $user->userable_id;
    }

    /**
     * Apply customer filter to query.
     */
    private static function applyCustomerFilter(NovaRequest $request, Builder $query): Builder
    {
        if (self::isCustomerUser($request)) {
            return $query->where('customer_id', $request->user()->userable_id);
        }

        // If not a customer, return empty query
        return $query->whereRaw('1 = 0');
    }

    /**
     * Get the ID field.
     */
    private function idField(): ID
    {
        return ID::make()->sortable()->hideFromIndex();
    }

    /**
     * Get the order number field.
     */
    private function orderNumberField(): Text
    {
        return Text::make('Order Number', 'formatted_order_number')
            ->sortable(false)
            ->readonly();
    }

    /**
     * Get the status field.
     */
    private function statusField(): Badge
    {
        return Badge::make('Status')->map([
            Order::STATUS_PENDING => 'warning',
            Order::STATUS_PROCESSING => 'info',
            Order::STATUS_ACTIVE => 'success',
            Order::STATUS_CANCELLED => 'danger',
            Order::STATUS_FRAUD => 'danger',
        ])->sortable();
    }

    /**
     * Get the total field.
     */
    private function totalField(): Currency
    {
        return Currency::make('Total')
            ->currency('USD')
            ->sortable()
            ->readonly();
    }

    /**
     * Get the order date field.
     */
    private function orderDateField(): DateTime
    {
        return DateTime::make('Order Date', 'ordered_at')
            ->sortable()
            ->readonly()
            ->displayUsing(fn($value) => $value?->format('M d, Y'));
    }

    /**
     * Get the order items field.
     */
    private function orderItemsField(): HasMany
    {
        return HasMany::make('Order Items', 'items', CustomerOrderItem::class)
            ->readonly();
    }

    /**
     * Get the invoice field.
     */
    private function invoiceField(): BelongsTo
    {
        return BelongsTo::make('Invoice')
            ->nullable()
            ->readonly()
            ->hideFromIndex();
    }
}
