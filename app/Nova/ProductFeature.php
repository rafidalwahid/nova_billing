<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductFeature extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductFeature>
     */
    public static $model = \App\Models\ProductFeature::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Product Features';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Product Feature';
    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Product Catalog';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'display_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'display_name', 'feature_key', 'feature_value',
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

            BelongsTo::make('Product')
                ->sortable()
                ->searchable()
                ->showCreateRelationButton()
                ->display('name'),

            Select::make('Feature Type', 'feature_type')
                ->options([
                    'storage' => 'Storage',
                    'bandwidth' => 'Bandwidth',
                    'domains' => 'Domains',
                    'email' => 'Email',
                    'ssl' => 'SSL',
                    'database' => 'Database',
                    'support' => 'Support',
                    'backup' => 'Backup',
                    'security' => 'Security',
                    'performance' => 'Performance',
                    'addon' => 'Add-on Service',
                    'other' => 'Other',
                ])
                ->sortable()
                ->rules('required'),

            Text::make('Feature Key', 'feature_key')
                ->help('Internal key for the feature (e.g., disk_space, monthly_bandwidth)')
                ->rules('required', 'max:100')
                ->sortable(),

            Text::make('Feature Value', 'feature_value')
                ->help('Value for the feature (e.g., 10, unlimited, yes, no)')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make('Display Name', 'display_name')
                ->help('User-friendly name shown in UI (e.g., "Disk Space", "Monthly Bandwidth")')
                ->rules('required', 'max:100')
                ->sortable(),

            Number::make('Display Order', 'display_order')
                ->help('Order in which features are displayed (lower numbers first)')
                ->default(0)
                ->min(0)
                ->step(1)
                ->sortable(),

            Boolean::make('Highlighted', 'is_highlighted')
                ->help('Show this feature prominently in the UI')
                ->sortable(),

            Text::make('Formatted Value', 'formatted_value')
                ->onlyOnIndex()
                ->sortable(false),
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
