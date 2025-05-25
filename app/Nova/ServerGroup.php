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

class ServerGroup extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ServerGroup>
     */
    public static $model = \App\Models\ServerGroup::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Product Catalog';

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
                    return $name . ' (' . $this->fill_method_display . ')';
                })
                ->onlyOnIndex(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Textarea::make('Description')
                ->rules('nullable', 'max:1000')
                ->hideFromIndex()
                ->alwaysShow(),

            Select::make('Fill Method')
                ->options([
                    'round_robin' => 'Round Robin',
                    'least_used' => 'Least Used',
                    'manual' => 'Manual Assignment',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required', 'in:round_robin,least_used,manual')
                ->filterable()
                ->help('How servers in this group should be selected for new hosting accounts'),

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

            Text::make('Products Count', function () {
                return $this->products()->count() . ' products assigned';
            })
                ->onlyOnIndex()
                ->sortable(false),

            HasMany::make('Products'),
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
