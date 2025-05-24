<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'description',
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

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->displayUsing(function ($name) {
                    return $name . ' (' . ucfirst($this->type) . ')';
                })
                ->onlyOnIndex(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Select::make('Type')
                ->options([
                    'hosting' => 'Hosting Package',
                    'domain' => 'Domain Registration',
                    'addon' => 'Addon Service',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:hosting,domain,addon')
                ->filterable(),

            Textarea::make('Description')
                ->rules('nullable', 'max:1000')
                ->hideFromIndex()
                ->alwaysShow(),

            Badge::make('Status', 'is_active')
                ->map([
                    true => 'success',
                    false => 'danger',
                ])
                ->labels([
                    true => 'Active',
                    false => 'Inactive',
                ])
                ->sortable()
                ->filterable(),

            Text::make('Pricing Summary', function () {
                $pricingCount = $this->pricing()->count();
                if ($pricingCount === 0) {
                    return 'No pricing configured';
                }

                $minPrice = $this->pricing()->min('recurring_fee');
                $maxPrice = $this->pricing()->max('recurring_fee');

                if ($minPrice === $maxPrice) {
                    return '$' . number_format($minPrice, 2);
                }

                return '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
            })
                ->onlyOnIndex()
                ->asHtml(),

            HasMany::make('Pricing', 'pricing', ProductPricing::class),
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
        return [
            new \App\Nova\Filters\ProductTypeFilter,
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
        return [];
    }
}
