<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\AdminUser;

class AssignedToMe extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'boolean-filter';

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
        if ($value) {
            $user = $request->user();
            
            // Get the admin user record for the authenticated user
            $adminUser = AdminUser::whereHas('user', function ($q) use ($user) {
                $q->where('id', $user->id);
            })->first();

            if ($adminUser) {
                return $query->where('assigned_to', $adminUser->id);
            }
            
            // If no admin user found, return empty results
            return $query->whereRaw('1 = 0');
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
            'Show only tickets assigned to me' => true,
        ];
    }
}
