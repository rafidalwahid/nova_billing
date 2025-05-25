<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SubscriptionItem extends Model
{
    // Type constants
    const TYPE_PRODUCT = 'product';
    const TYPE_ADDON = 'addon';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_FEE = 'fee';
    const TYPE_ADJUSTMENT = 'adjustment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id',
        'product_id',
        'type',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'billing_cycle',
        'is_active',
        'start_date',
        'end_date',
        'notes',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'metadata' => 'array',
    ];

    /**
     * Get the subscription that owns the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the product for this item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the item's type badge HTML.
     */
    protected function typeBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $badges = [
                    'product' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">📦 Product</span>',
                    'addon' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">🔧 Add-on</span>',
                    'discount' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">💰 Discount</span>',
                    'fee' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">💳 Fee</span>',
                    'adjustment' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">⚖️ Adjustment</span>',
                ];

                return $badges[$this->type] ?? $badges['product'];
            },
        );
    }

    /**
     * Get the item's status badge HTML.
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->is_active) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Active</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">⏸️ Inactive</span>';
                }
            },
        );
    }

    /**
     * Get the item's display name.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->description . ($this->quantity > 1 ? " (x{$this->quantity})" : ''),
        );
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include items of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include items for a specific subscription.
     */
    public function scopeForSubscription($query, $subscriptionId)
    {
        return $query->where('subscription_id', $subscriptionId);
    }
}
