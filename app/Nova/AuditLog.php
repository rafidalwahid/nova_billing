<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Http\Requests\NovaRequest;

class AuditLog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AuditLog>
     */
    public static $model = \App\Models\AuditLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'action_description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'action_description', 'event', 'auditable_type',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     */
    public static $displayInNavigation = true;

    /**
     * The logical group associated with the resource.
     */
    public static $group = 'System';

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with(['user'])->latest();
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

            BelongsTo::make('User')
                ->nullable()
                ->displayUsing(function ($user) {
                    return $user ? $user->name : 'System';
                }),

            Text::make('Event')
                ->sortable()
                ->filterable(),

            Text::make('Action Description')
                ->sortable()
                ->displayUsing(function ($value) {
                    return \Str::limit($value, 50);
                }),

            Badge::make('Category')
                ->map([
                    'financial' => 'danger',
                    'customer' => 'info',
                    'security' => 'warning',
                    'system' => 'success',
                    'general' => 'info',
                ])
                ->sortable()
                ->filterable(),

            Badge::make('Severity')
                ->map([
                    'critical' => 'danger',
                    'high' => 'warning',
                    'medium' => 'info',
                    'low' => 'success',
                ])
                ->sortable()
                ->filterable(),

            Text::make('Auditable Type')
                ->displayUsing(function ($value) {
                    return class_basename($value);
                })
                ->sortable()
                ->filterable(),

            Text::make('Auditable ID')
                ->sortable(),

            Text::make('IP Address')
                ->hideFromIndex(),

            Code::make('Old Values')
                ->json()
                ->hideFromIndex(),

            Code::make('New Values')
                ->json()
                ->hideFromIndex(),

            Code::make('Metadata')
                ->json()
                ->hideFromIndex(),

            DateTime::make('Created At')
                ->sortable()
                ->filterable(),
        ];
    }

    /**
     * Determine if this resource is available for navigation.
     */
    public static function availableForNavigation($request): bool
    {
        return $request->user() && $request->user()->isAdmin();
    }

    /**
     * Determine if the current user can create new resources.
     */
    public static function authorizedToCreate($request): bool
    {
        return false; // Audit logs should not be manually created
    }

    /**
     * Determine if the current user can update the given resource.
     */
    public function authorizedToUpdate($request): bool
    {
        return false; // Audit logs should not be editable
    }

    /**
     * Determine if the current user can delete the given resource.
     */
    public function authorizedToDelete($request): bool
    {
        return false; // Audit logs should not be deletable
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
