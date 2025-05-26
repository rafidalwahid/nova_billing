<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;

class HostingAccount extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\HostingAccount>
     */
    public static $model = \App\Models\HostingAccount::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'username';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Infrastructure Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'username', 'domain', 'account_number',
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

            Text::make('Account Number')
                ->sortable()
                ->rules('required', 'unique:hosting_accounts,account_number,{{resourceId}}'),

            Text::make('Username')
                ->sortable()
                ->rules('required', 'unique:hosting_accounts,username,{{resourceId}}'),

            Text::make('Domain')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required')
                ->searchable()
                ->display(function ($customer) {
                    return $customer->first_name . ' ' . $customer->last_name;
                }),

            BelongsTo::make('Server')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required'),

            Badge::make('Status')->map([
                'pending' => 'warning',
                'active' => 'success',
                'suspended' => 'danger',
                'terminated' => 'danger',
                'cancelled' => 'info',
            ])->sortable()
            ->displayUsing(function ($status) {
                return match($status) {
                    'pending' => '🟡 Pending Setup',
                    'active' => '🟢 Active',
                    'suspended' => '🔴 Suspended',
                    'terminated' => '🔴 Terminated',
                    'cancelled' => '⚪ Cancelled',
                    default => ucfirst($status),
                };
            }),
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
