<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_pricing_id',
        'product_name',
        'billing_cycle',
        'quantity',
        'unit_price',
        'setup_fee',
        'total_price',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product pricing for the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productPricing(): BelongsTo
    {
        return $this->belongsTo(ProductPricing::class);
    }

    /**
     * Get the formatted billing cycle.
     */
    protected function formattedBillingCycle(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->billing_cycle) {
                'monthly' => 'Monthly',
                'quarterly' => 'Quarterly',
                'semi_annually' => 'Semi-Annually',
                'annually' => 'Annually',
                'biennially' => 'Biennially',
                'triennially' => 'Triennially',
                default => ucfirst($this->billing_cycle),
            },
        );
    }

    /**
     * Get the line total (quantity * unit_price + setup_fee).
     */
    protected function lineTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->quantity * $this->unit_price) + $this->setup_fee,
        );
    }
}
