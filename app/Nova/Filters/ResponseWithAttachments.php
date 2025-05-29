<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ResponseWithAttachments extends Filter
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
        if ($value === 'with_attachments') {
            return $query->whereNotNull('attachments')
                        ->where('attachments', '!=', '[]')
                        ->where('attachments', '!=', 'null');
        } elseif ($value === 'without_attachments') {
            return $query->where(function ($q) {
                $q->whereNull('attachments')
                  ->orWhere('attachments', '[]')
                  ->orWhere('attachments', 'null');
            });
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
            'With Attachments' => 'with_attachments',
            'Without Attachments' => 'without_attachments',
        ];
    }

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return 'Has Attachments';
    }
}
