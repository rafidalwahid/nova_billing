<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductFeature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'feature_type',
        'feature_key',
        'feature_value',
        'display_name',
        'display_order',
        'is_highlighted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_highlighted' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the product that owns the feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted feature value for display.
     */
    protected function formattedValue(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->feature_type) {
                'storage' => $this->formatStorage($this->feature_value),
                'bandwidth' => $this->formatBandwidth($this->feature_value),
                'boolean' => $this->feature_value ? 'Yes' : 'No',
                'number' => number_format($this->feature_value),
                'unlimited' => 'Unlimited',
                default => $this->feature_value,
            },
        );
    }

    /**
     * Format storage values (GB, TB, etc.)
     */
    private function formatStorage(string $value): string
    {
        if ($value === 'unlimited') {
            return 'Unlimited';
        }

        $numeric = (float) $value;
        if ($numeric >= 1024) {
            return number_format($numeric / 1024, 1) . ' TB';
        }

        return number_format($numeric) . ' GB';
    }

    /**
     * Format bandwidth values
     */
    private function formatBandwidth(string $value): string
    {
        if ($value === 'unlimited') {
            return 'Unlimited';
        }

        $numeric = (float) $value;
        if ($numeric >= 1024) {
            return number_format($numeric / 1024, 1) . ' TB';
        }

        return number_format($numeric) . ' GB';
    }

    /**
     * Scope a query to only include features of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('feature_type', $type);
    }

    /**
     * Scope a query to only include highlighted features.
     */
    public function scopeHighlighted($query)
    {
        return $query->where('is_highlighted', true);
    }

    /**
     * Scope a query to order features by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('display_name');
    }
}
