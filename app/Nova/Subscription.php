<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Subscription as SubscriptionModel;

class Subscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Subscription>
     */
    public static $model = \App\Models\Subscription::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'display_name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Subscription Management';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'subscription_number', 'notes',
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

            BelongsTo::make('Customer')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Order')
                ->nullable()
                ->sortable()
                ->searchable()
                ->hideFromIndex(),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Product Pricing')
                ->sortable()
                ->rules('required')
                ->searchable()
                ->hideFromIndex(),

            Text::make('Subscription Number')
                ->sortable()
                ->rules('required', 'max:50')
                ->creationRules('unique:subscriptions,subscription_number')
                ->updateRules('unique:subscriptions,subscription_number,{{resourceId}}'),

            // Beautiful status badge with gradient styling
            Text::make('Status', function () {
                $colors = [
                    'pending' => '#f59e0b',     // Amber
                    'active' => '#10b981',      // Emerald
                    'suspended' => '#f97316',   // Orange
                    'cancelled' => '#ef4444',   // Red
                    'expired' => '#6b7280',     // Gray
                ];

                $icons = [
                    'pending' => '⏳',
                    'active' => '✅',
                    'suspended' => '⏸️',
                    'cancelled' => '❌',
                    'expired' => '⏰',
                ];

                $labels = [
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'suspended' => 'Suspended',
                    'cancelled' => 'Cancelled',
                    'expired' => 'Expired',
                ];

                $color = $colors[$this->status] ?? $colors['pending'];
                $icon = $icons[$this->status] ?? $icons['pending'];
                $label = $labels[$this->status] ?? ucfirst($this->status);

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$icon} {$label}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Select::make('Status')
                ->options([
                    SubscriptionModel::STATUS_PENDING => 'Pending',
                    SubscriptionModel::STATUS_ACTIVE => 'Active',
                    SubscriptionModel::STATUS_SUSPENDED => 'Suspended',
                    SubscriptionModel::STATUS_CANCELLED => 'Cancelled',
                    SubscriptionModel::STATUS_EXPIRED => 'Expired',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:pending,active,suspended,cancelled,expired')
                ->default(SubscriptionModel::STATUS_PENDING)
                ->hideFromIndex()
                ->filterable(),

            // Beautiful billing cycle badge
            Text::make('Billing Cycle', function () {
                $colors = [
                    'monthly' => '#3b82f6',      // Blue
                    'quarterly' => '#8b5cf6',    // Purple
                    'semi_annually' => '#06b6d4', // Cyan
                    'annually' => '#10b981',     // Emerald
                ];

                $icons = [
                    'monthly' => '📅',
                    'quarterly' => '📊',
                    'semi_annually' => '⏰',
                    'annually' => '🗓️',
                ];

                $labels = [
                    'monthly' => 'Monthly',
                    'quarterly' => 'Quarterly',
                    'semi_annually' => 'Semi-Annual',
                    'annually' => 'Annual',
                ];

                $color = $colors[$this->billing_cycle] ?? $colors['monthly'];
                $icon = $icons[$this->billing_cycle] ?? $icons['monthly'];
                $label = $labels[$this->billing_cycle] ?? ucfirst($this->billing_cycle);

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$icon} {$label}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

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
                ->filterable()
                ->hideFromIndex(),

            Currency::make('Recurring Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->step(0.01),

            Currency::make('Setup Fee')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->default(0.00)
                ->step(0.01)
                ->hideFromIndex(),

            Text::make('Currency')
                ->default('USD')
                ->rules('required', 'size:3')
                ->hideFromIndex(),

            Date::make('Start Date')
                ->sortable()
                ->rules('required')
                ->default(now()),

            Date::make('Next Billing Date')
                ->sortable()
                ->rules('required'),

            Date::make('End Date')
                ->nullable()
                ->hideFromIndex(),

            Date::make('Trial End Date')
                ->nullable()
                ->hideFromIndex(),

            Date::make('Cancelled At')
                ->nullable()
                ->hideFromIndex(),

            Date::make('Suspended At')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Billing Cycles Completed')
                ->default(0)
                ->rules('required', 'integer', 'min:0')
                ->hideFromIndex(),

            Number::make('Failed Payment Attempts')
                ->default(0)
                ->rules('required', 'integer', 'min:0')
                ->hideFromIndex(),

            Date::make('Last Billing Date')
                ->nullable()
                ->hideFromIndex(),

            Textarea::make('Notes')
                ->hideFromIndex()
                ->nullable(),

            // Relationships
            HasMany::make('Subscription Items', 'items', SubscriptionItem::class),
            HasMany::make('Invoices'),
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

    /**
     * Adjust color brightness for gradient effects
     */
    private function adjustBrightness($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, min(255, $r + ($r * $percent / 100)));
        $g = max(0, min(255, $g + ($g * $percent / 100)));
        $b = max(0, min(255, $b + ($b * $percent / 100)));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
