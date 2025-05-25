<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Subscription extends Model
{
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'order_id',
        'product_id',
        'product_pricing_id',
        'subscription_number',
        'status',
        'billing_cycle',
        'recurring_amount',
        'setup_fee',
        'currency',
        'start_date',
        'next_billing_date',
        'end_date',
        'trial_end_date',
        'cancelled_at',
        'suspended_at',
        'billing_cycles_completed',
        'failed_payment_attempts',
        'last_billing_date',
        'notes',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'recurring_amount' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'start_date' => 'date',
        'next_billing_date' => 'date',
        'end_date' => 'date',
        'trial_end_date' => 'date',
        'cancelled_at' => 'date',
        'suspended_at' => 'date',
        'last_billing_date' => 'date',
        'billing_cycles_completed' => 'integer',
        'failed_payment_attempts' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get the customer that owns the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order that created this subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for this subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product pricing for this subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productPricing(): BelongsTo
    {
        return $this->belongsTo(ProductPricing::class);
    }

    /**
     * Get the subscription items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SubscriptionItem::class);
    }

    /**
     * Get the invoices generated for this subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the subscription's display name.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->subscription_number} - {$this->product->name}",
        );
    }

    /**
     * Get the subscription's status badge HTML.
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $badges = [
                    'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">⏳ Pending</span>',
                    'active' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Active</span>',
                    'suspended' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">⏸️ Suspended</span>',
                    'cancelled' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Cancelled</span>',
                    'expired' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">⏰ Expired</span>',
                ];

                return $badges[$this->status] ?? $badges['pending'];
            },
        );
    }

    /**
     * Get the billing cycle display name.
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
     * Check if the subscription is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the subscription is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Check if the subscription is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if the subscription is due for billing.
     */
    public function isDueForBilling(): bool
    {
        return $this->isActive() &&
               $this->next_billing_date &&
               $this->next_billing_date->lte(Carbon::today());
    }

    /**
     * Calculate the next billing date based on billing cycle.
     */
    public function calculateNextBillingDate(Carbon $fromDate = null): Carbon
    {
        $fromDate = $fromDate ?? Carbon::parse($this->next_billing_date ?? $this->start_date);

        return match($this->billing_cycle) {
            'monthly' => $fromDate->addMonth(),
            'quarterly' => $fromDate->addMonths(3),
            'semi_annually' => $fromDate->addMonths(6),
            'annually' => $fromDate->addYear(),
            default => $fromDate->addMonth(),
        };
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include subscriptions due for billing.
     */
    public function scopeDueForBilling($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                    ->whereDate('next_billing_date', '<=', Carbon::today());
    }

    /**
     * Scope a query to only include subscriptions for a specific customer.
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to only include subscriptions for a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
