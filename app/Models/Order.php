<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'order_number',
        'status',
        'subtotal',
        'tax_amount',
        'total',
        'currency',
        'notes',
        'ordered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'ordered_at' => 'datetime',
    ];

    /**
     * Order status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FRAUD = 'fraud';

    /**
     * Get all available order statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending Payment',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_FRAUD => 'Fraud',
        ];
    }

    /**
     * Get the customer that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the invoice for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the subscriptions created from this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the formatted order number.
     */
    protected function formattedOrderNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get the status badge color.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_PENDING => 'warning',
                self::STATUS_PROCESSING => 'info',
                self::STATUS_ACTIVE => 'success',
                self::STATUS_CANCELLED => 'danger',
                self::STATUS_FRAUD => 'danger',
                default => 'secondary',
            },
        );
    }

    /**
     * Scope a query to only include orders with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include active orders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
}