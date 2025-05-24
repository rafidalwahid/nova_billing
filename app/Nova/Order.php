<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static $model = \App\Models\Order::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Orders';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Order';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Order Management';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'formatted_order_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'order_number',
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

            Text::make('Order Number', 'formatted_order_number')
                ->onlyOnIndex()
                ->sortable(false),

            Text::make('Order Number', 'order_number')
                ->hideFromIndex()
                ->rules('required', 'unique:orders,order_number,{{resourceId}}')
                ->help('Unique order identifier'),

            BelongsTo::make('Customer')
                ->sortable()
                ->searchable()
                ->showCreateRelationButton()
                ->display('full_name'),

            Badge::make('Status')->map([
                \App\Models\Order::STATUS_PENDING => 'warning',
                \App\Models\Order::STATUS_PROCESSING => 'info',
                \App\Models\Order::STATUS_ACTIVE => 'success',
                \App\Models\Order::STATUS_CANCELLED => 'danger',
                \App\Models\Order::STATUS_FRAUD => 'danger',
            ])->sortable(),

            Select::make('Status')
                ->options(\App\Models\Order::getStatuses())
                ->hideFromIndex()
                ->rules('required'),

            Currency::make('Subtotal')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            Currency::make('Tax Amount', 'tax_amount')
                ->currency('USD')
                ->sortable()
                ->rules('numeric', 'min:0'),

            Currency::make('Total')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            Text::make('Currency')
                ->default('USD')
                ->rules('required', 'size:3')
                ->hideFromIndex(),

            DateTime::make('Ordered At', 'ordered_at')
                ->sortable()
                ->rules('required'),

            Textarea::make('Notes')
                ->hideFromIndex()
                ->nullable(),

            HasMany::make('Order Items', 'items', OrderItem::class),
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
