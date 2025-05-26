<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasBillingCycle;

class ProductPricing extends Model
{
    use HasBillingCycle;
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
     * Get the subscriptions using this pricing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    // Billing cycle display moved to HasBillingCycle trait

    /**
     * Get the total first payment (setup + recurring).
     */
    protected function firstPayment(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->setup_fee + $this->recurring_fee,
        );
    }
}
