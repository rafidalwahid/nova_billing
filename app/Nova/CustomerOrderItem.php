<?php

namespace App\Nova;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerOrderItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<OrderItem>
     */
    public static $model = OrderItem::class;

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return 'Order Items';
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return 'Order Item';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'product_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'product_name',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Determine if this resource is available for navigation.
     */
    public static function availableForNavigation(Request $request): bool
    {
        return false; // Never show in navigation - only accessible through orders
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

        // Customers can only view order items from their own orders
        if ($user->isCustomer()) {
            return $this->isCustomerOrderItem($user);
        }

        // Staff users can view all order items (if they have permission)
        return true;
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return self::applyCustomerFilter($request, $query->with(['order', 'product']));
    }

    /**
     * Build a "detail" query for the given resource.
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return self::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            Text::make('Product Name')->readonly(),
            Text::make('Description')->hideFromIndex()->readonly(),
            Number::make('Quantity')->readonly(),
            Currency::make('Unit Price')->currency('USD')->readonly(),
            Currency::make('Setup Fee')->currency('USD')->readonly()->hideFromIndex(),
            Currency::make('Total Price')->currency('USD')->readonly(),
            Text::make('Billing Cycle')->hideFromIndex()->readonly(),
            BelongsTo::make('Product')->hideFromIndex()->readonly(),
        ];
    }

    /**
     * Get the cards available for the resource.
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
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
     * Check if the order item belongs to the current customer.
     */
    private function isCustomerOrderItem($user): bool
    {
        return $this->resource->order->customer_id === $user->userable_id;
    }

    /**
     * Apply customer filter to query.
     */
    private static function applyCustomerFilter(NovaRequest $request, $query)
    {
        if (self::isCustomerUser($request)) {
            return $query->whereHas('order', function ($orderQuery) use ($request) {
                $orderQuery->where('customer_id', $request->user()->userable_id);
            });
        }

        // If not a customer, return empty query
        return $query->whereRaw('1 = 0');
    }
}
