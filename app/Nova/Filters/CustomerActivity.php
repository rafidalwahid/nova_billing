<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerActivity extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        switch ($value) {
            case 'recent_7':
                return $query->where('last_login', '>=', now()->subDays(7));
            case 'recent_30':
                return $query->where('last_login', '>=', now()->subDays(30));
            case 'recent_90':
                return $query->where('last_login', '>=', now()->subDays(90));
            case 'inactive_30':
                return $query->where('last_login', '<', now()->subDays(30))
                            ->orWhereNull('last_login');
            case 'inactive_90':
                return $query->where('last_login', '<', now()->subDays(90))
                            ->orWhereNull('last_login');
            case 'never_logged_in':
                return $query->whereNull('last_login');
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            'Active in last 7 days' => 'recent_7',
            'Active in last 30 days' => 'recent_30',
            'Active in last 90 days' => 'recent_90',
            'Inactive for 30+ days' => 'inactive_30',
            'Inactive for 90+ days' => 'inactive_90',
            'Never logged in' => 'never_logged_in',
        ];
    }

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return 'Customer Activity';
    }
}
