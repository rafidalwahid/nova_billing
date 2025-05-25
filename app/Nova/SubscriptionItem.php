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
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\SubscriptionItem as SubscriptionItemModel;

class SubscriptionItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\SubscriptionItem>
     */
    public static $model = \App\Models\SubscriptionItem::class;

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
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'description', 'notes',
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

            BelongsTo::make('Subscription')
                ->sortable()
                ->rules('required')
                ->searchable(),

            BelongsTo::make('Product')
                ->nullable()
                ->sortable()
                ->searchable()
                ->hideFromIndex(),

            // Beautiful type badge with gradient styling
            Text::make('Type', function () {
                $colors = [
                    'product' => '#3b82f6',     // Blue
                    'addon' => '#8b5cf6',       // Purple
                    'discount' => '#10b981',    // Emerald
                    'fee' => '#f97316',         // Orange
                    'adjustment' => '#6b7280',  // Gray
                ];

                $icons = [
                    'product' => '📦',
                    'addon' => '🔧',
                    'discount' => '💰',
                    'fee' => '💳',
                    'adjustment' => '⚖️',
                ];

                $labels = [
                    'product' => 'Product',
                    'addon' => 'Add-on',
                    'discount' => 'Discount',
                    'fee' => 'Fee',
                    'adjustment' => 'Adjustment',
                ];

                $color = $colors[$this->type] ?? $colors['product'];
                $icon = $icons[$this->type] ?? $icons['product'];
                $label = $labels[$this->type] ?? ucfirst($this->type);

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$icon} {$label}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Select::make('Type')
                ->options([
                    SubscriptionItemModel::TYPE_PRODUCT => 'Product',
                    SubscriptionItemModel::TYPE_ADDON => 'Add-on',
                    SubscriptionItemModel::TYPE_DISCOUNT => 'Discount',
                    SubscriptionItemModel::TYPE_FEE => 'Fee',
                    SubscriptionItemModel::TYPE_ADJUSTMENT => 'Adjustment',
                ])
                ->displayUsingLabels()
                ->rules('required', 'in:product,addon,discount,fee,adjustment')
                ->default(SubscriptionItemModel::TYPE_PRODUCT)
                ->hideFromIndex()
                ->filterable(),

            Text::make('Description')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make('Quantity')
                ->sortable()
                ->rules('required', 'integer', 'min:1')
                ->default(1)
                ->step(1),

            Currency::make('Unit Price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric')
                ->step(0.01),

            Currency::make('Total Price')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric')
                ->step(0.01),

            Text::make('Billing Cycle')
                ->nullable()
                ->hideFromIndex()
                ->rules('nullable', 'max:50'),

            // Beautiful status badge with gradient styling
            Text::make('Status', function () {
                $color = $this->is_active ? '#10b981' : '#6b7280';
                $icon = $this->is_active ? '✅' : '⏸️';
                $label = $this->is_active ? 'Active' : 'Inactive';

                return "<span style='display: inline-flex; align-items: center; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; color: white; background: linear-gradient(135deg, {$color}, " . $this->adjustBrightness($color, -20) . ");'>{$icon} {$label}</span>";
            })
                ->asHtml()
                ->onlyOnIndex(),

            Boolean::make('Is Active')
                ->default(true)
                ->hideFromIndex(),

            Date::make('Start Date')
                ->sortable()
                ->rules('required')
                ->default(now()),

            Date::make('End Date')
                ->nullable()
                ->hideFromIndex(),

            Textarea::make('Notes')
                ->hideFromIndex()
                ->nullable(),
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
