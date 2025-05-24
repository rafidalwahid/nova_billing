<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\OrderItem>
     */
    public static $model = \App\Models\OrderItem::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Order Items';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Order Item';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Order Management';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

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
        'product_name', 'billing_cycle',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Order')
                ->sortable()
                ->searchable()
                ->showCreateRelationButton()
                ->display('order_number'),

            BelongsTo::make('Product')
                ->sortable()
                ->searchable()
                ->showCreateRelationButton()
                ->display('name'),

            BelongsTo::make('Product Pricing', 'productPricing', ProductPricing::class)
                ->nullable()
                ->sortable()
                ->searchable()
                ->display('billing_cycle'),

            Text::make('Product Name', 'product_name')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Product name at time of order'),

            Text::make('Billing Cycle', 'billing_cycle')
                ->sortable()
                ->rules('required', 'max:50'),

            Text::make('Formatted Billing Cycle', 'formatted_billing_cycle')
                ->onlyOnIndex()
                ->sortable(false),

            Number::make('Quantity')
                ->sortable()
                ->rules('required', 'integer', 'min:1')
                ->default(1),

            Currency::make('Unit Price', 'unit_price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            Currency::make('Setup Fee', 'setup_fee')
                ->currency('USD')
                ->sortable()
                ->rules('numeric', 'min:0')
                ->default(0),

            Currency::make('Total Price', 'total_price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            Currency::make('Line Total', 'line_total')
                ->currency('USD')
                ->onlyOnIndex()
                ->sortable(false),

            Textarea::make('Description')
                ->hideFromIndex()
                ->nullable(),
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
        return [];
    }
}
