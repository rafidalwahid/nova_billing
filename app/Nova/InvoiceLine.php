<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use App\Models\InvoiceLine as InvoiceLineModel;

class InvoiceLine extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\InvoiceLine>
     */
    public static $model = \App\Models\InvoiceLine::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'description', 'notes',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Invoice Lines';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Invoice Line';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Invoice')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Order Item')
                ->nullable()
                ->hideFromIndex(),

            Select::make('Type')
                ->options([
                    InvoiceLineModel::TYPE_PRODUCT => 'Product',
                    InvoiceLineModel::TYPE_SERVICE => 'Service',
                    InvoiceLineModel::TYPE_DISCOUNT => 'Discount',
                    InvoiceLineModel::TYPE_TAX => 'Tax',
                    InvoiceLineModel::TYPE_FEE => 'Fee',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:product,service,discount,tax,fee')
                ->default(InvoiceLineModel::TYPE_PRODUCT)
                ->filterable(),

            Text::make('Description')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make('Quantity')
                ->sortable()
                ->rules('required', 'integer', 'min:1')
                ->default(1)
                ->step(1),

            Currency::make('Unit Price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric')
                ->step(0.01),

            Currency::make('Total Price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric')
                ->step(0.01),

            Text::make('Billing Cycle')
                ->nullable()
                ->hideFromIndex()
                ->rules('nullable', 'max:50'),

            Textarea::make('Notes')
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
