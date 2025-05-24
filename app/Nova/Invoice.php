<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use App\Models\Invoice as InvoiceModel;

class Invoice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Invoice>
     */
    public static $model = \App\Models\Invoice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'invoice_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'invoice_number', 'notes',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Invoices';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Invoice';
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

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Order')
                ->nullable()
                ->sortable()
                ->searchable()
                ->hideFromIndex(),

            Text::make('Invoice Number')
                ->sortable()
                ->rules('required', 'max:50')
                ->creationRules('unique:invoices,invoice_number')
                ->updateRules('unique:invoices,invoice_number,{{resourceId}}'),

            Badge::make('Status')
                ->map([
                    InvoiceModel::STATUS_DRAFT => 'secondary',
                    InvoiceModel::STATUS_SENT => 'info',
                    InvoiceModel::STATUS_PAID => 'success',
                    InvoiceModel::STATUS_OVERDUE => 'danger',
                    InvoiceModel::STATUS_CANCELLED => 'warning',
                ])
                ->labels([
                    InvoiceModel::STATUS_DRAFT => 'Draft',
                    InvoiceModel::STATUS_SENT => 'Sent',
                    InvoiceModel::STATUS_PAID => 'Paid',
                    InvoiceModel::STATUS_OVERDUE => 'Overdue',
                    InvoiceModel::STATUS_CANCELLED => 'Cancelled',
                ])
                ->sortable(),

            Select::make('Status')
                ->options([
                    InvoiceModel::STATUS_DRAFT => 'Draft',
                    InvoiceModel::STATUS_SENT => 'Sent',
                    InvoiceModel::STATUS_PAID => 'Paid',
                    InvoiceModel::STATUS_OVERDUE => 'Overdue',
                    InvoiceModel::STATUS_CANCELLED => 'Cancelled',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:draft,sent,paid,overdue,cancelled')
                ->default(InvoiceModel::STATUS_DRAFT)
                ->hideFromIndex()
                ->filterable(),

            Currency::make('Subtotal')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01),

            Currency::make('Tax Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01)
                ->hideFromIndex(),

            Currency::make('Total')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01),

            Currency::make('Balance Due')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01),

            Text::make('Currency')
                ->default('USD')
                ->rules('required', 'size:3')
                ->hideFromIndex(),

            Date::make('Invoice Date')
                ->sortable()
                ->rules('required')
                ->default(now()),

            Date::make('Due Date')
                ->sortable()
                ->rules('required')
                ->default(now()->addDays(30)),

            Date::make('Paid Date')
                ->nullable()
                ->hideFromIndex(),

            Textarea::make('Notes')
                ->hideFromIndex()
                ->nullable(),

            Textarea::make('Terms')
                ->hideFromIndex()
                ->nullable(),

            HasMany::make('Invoice Lines', 'lines', InvoiceLine::class),
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
