<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class DomainRegistration extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\DomainRegistration>
     */
    public static $model = \App\Models\DomainRegistration::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'domain_name';

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
        'id', 'domain_name', 'tld',
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

            Text::make('Domain Name')
                ->sortable()
                ->rules('required')
                ->displayUsing(function ($value) {
                    return $value . $this->tld;
                })
                ->onlyOnIndex(),

            Text::make('Domain Name')
                ->sortable()
                ->rules('required')
                ->help('Domain name without TLD (e.g., example)')
                ->hideFromIndex(),

            Text::make('TLD')
                ->sortable()
                ->rules('required')
                ->help('Top Level Domain (e.g., .com, .net, .org)'),

            Text::make('Registrar')
                ->sortable()
                ->rules('required')
                ->displayUsing(function ($value) {
                    return match($value) {
                        'namecheap' => 'Namecheap',
                        'godaddy' => 'GoDaddy',
                        'cloudflare' => 'Cloudflare',
                        default => ucfirst($value),
                    };
                }),

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required'),

            Badge::make('Status', 'computed_status')->map([
                'pending' => 'warning',
                'active' => 'success',
                'expired' => 'danger',
                'suspended' => 'danger',
                'cancelled' => 'info',
                'transferred' => 'info',
            ])->sortable()
            ->displayUsing(function ($status) {
                return match($status) {
                    'pending' => '🟡 Pending Registration',
                    'active' => '🟢 Active',
                    'expired' => '🔴 Expired',
                    'suspended' => '🔴 Suspended',
                    'cancelled' => '⚪ Cancelled',
                    'transferred' => '🔄 Transferred Out',
                    default => ucfirst($status),
                };
            }),

            Date::make('Registration Date')
                ->sortable()
                ->nullable(),

            Text::make('Expiration Status', 'expiration_status_text')
                ->sortable()
                ->displayUsing(function ($value) {
                    if (!$this->expiration_date) return 'N/A';

                    $days = $this->days_until_expiration;

                    if ($days < 0) {
                        return "🔴 " . $value;
                    }

                    if ($days <= 7) {
                        return "🔴 " . $value;
                    }

                    if ($days <= 30) {
                        return "🟡 " . $value;
                    }

                    return "🟢 " . $value;
                }),

            Date::make('Expiration Date')
                ->sortable()
                ->nullable()
                ->onlyOnDetail(),
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
