<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductPricing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'billing_cycle',
        'setup_fee',
        'recurring_fee',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'setup_fee' => 'decimal:2',
        'recurring_fee' => 'decimal:2',
    ];

    /**
     * Get the product that owns the pricing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted billing cycle display name.
     */
    protected function billingCycleDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->billing_cycle) {
                'monthly' => 'Monthly',
                'quarterly' => 'Quarterly (3 months)',
                'semi_annually' => 'Semi-Annually (6 months)',
                'annually' => 'Annually (12 months)',
                default => ucfirst($this->billing_cycle),
            },
        );
    }

    /**
     * Get the total first payment (setup + recurring).
     */
    protected function firstPayment(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->setup_fee + $this->recurring_fee,
        );
    }

    /**
     * Scope a query to only include specific billing cycles.
     */
    public function scopeForBillingCycle($query, $cycle)
    {
        return $query->where('billing_cycle', $cycle);
    }
}
