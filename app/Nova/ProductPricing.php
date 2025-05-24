<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductPricing extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductPricing>
     */
    public static $model = \App\Models\ProductPricing::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'billing_cycle_display';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'billing_cycle',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required')
                ->searchable(),

            Select::make('Billing Cycle')
                ->options([
                    'monthly' => 'Monthly',
                    'quarterly' => 'Quarterly (3 months)',
                    'semi_annually' => 'Semi-Annually (6 months)',
                    'annually' => 'Annually (12 months)',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:monthly,quarterly,semi_annually,annually')
                ->filterable(),

            Currency::make('Setup Fee')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01),

            Currency::make('Recurring Fee')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->step(0.01),

            Text::make('First Payment', function () {
                return '$' . number_format($this->setup_fee + $this->recurring_fee, 2);
            })
                ->onlyOnIndex()
                ->sortable(false),

            Text::make('Savings vs Monthly', function () {
                if ($this->billing_cycle === 'monthly') {
                    return 'Base price';
                }

                // Find monthly pricing for same product
                $monthlyPricing = $this->product->pricing()
                    ->where('billing_cycle', 'monthly')
                    ->first();

                if (!$monthlyPricing) {
                    return 'No monthly comparison';
                }

                $monthlyTotal = $monthlyPricing->recurring_fee * $this->getMonthsInCycle();
                $thisTotal = $this->recurring_fee;
                $savings = $monthlyTotal - $thisTotal;

                if ($savings > 0) {
                    $percentage = round(($savings / $monthlyTotal) * 100, 1);
                    return '$' . number_format($savings, 2) . ' (' . $percentage . '% off)';
                }

                return 'No savings';
            })
                ->onlyOnIndex()
                ->asHtml(),
        ];
    }

    /**
     * Get the number of months in the billing cycle.
     */
    private function getMonthsInCycle(): int
    {
        return match($this->billing_cycle) {
            'monthly' => 1,
            'quarterly' => 3,
            'semi_annually' => 6,
            'annually' => 12,
            default => 1,
        };
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
