<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class InvoiceLine extends Model
{
    // Type constants
    const TYPE_PRODUCT = 'product';
    const TYPE_SERVICE = 'service';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_TAX = 'tax';
    const TYPE_FEE = 'fee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'order_item_id',
        'type',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'billing_cycle',
        'notes',
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
    ];

    /**
     * Get the invoice that owns the invoice line.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the order item that this invoice line is based on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the formatted type display name.
     */
    protected function typeDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->type) {
                self::TYPE_PRODUCT => 'Product',
                self::TYPE_SERVICE => 'Service',
                self::TYPE_DISCOUNT => 'Discount',
                self::TYPE_TAX => 'Tax',
                self::TYPE_FEE => 'Fee',
                default => ucfirst($this->type),
            },
        );
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
                default => $this->billing_cycle ? ucfirst($this->billing_cycle) : null,
            },
        );
    }

    /**
     * Get the calculated line total (quantity * unit_price).
     */
    protected function calculatedTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity * $this->unit_price,
        );
    }

    /**
     * Scope a query to only include specific line types.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include product lines.
     */
    public function scopeProducts($query)
    {
        return $query->where('type', self::TYPE_PRODUCT);
    }

    /**
     * Scope a query to only include service lines.
     */
    public function scopeServices($query)
    {
        return $query->where('type', self::TYPE_SERVICE);
    }

    /**
     * Scope a query to only include discount lines.
     */
    public function scopeDiscounts($query)
    {
        return $query->where('type', self::TYPE_DISCOUNT);
    }
}
