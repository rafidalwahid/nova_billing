<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    // Type constants
    const TYPE_PAYMENT = 'payment';
    const TYPE_REFUND = 'refund';
    const TYPE_CHARGEBACK = 'chargeback';
    const TYPE_FEE = 'fee';
    const TYPE_ADJUSTMENT = 'adjustment';

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'customer_id',
        'type',
        'amount',
        'currency',
        'gateway_transaction_id',
        'gateway_reference',
        'gateway_response',
        'status',
        'processed_at',
        'description',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the payment that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the customer that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the formatted transaction reference.
     */
    protected function formattedReference(): Attribute
    {
        return Attribute::make(
            get: fn () => 'TXN-' . str_pad($this->id, 8, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get the type badge color.
     */
    protected function typeColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->type) {
                self::TYPE_PAYMENT => 'success',
                self::TYPE_REFUND => 'info',
                self::TYPE_CHARGEBACK => 'danger',
                self::TYPE_FEE => 'warning',
                self::TYPE_ADJUSTMENT => 'secondary',
                default => 'secondary',
            },
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
                self::STATUS_COMPLETED => 'success',
                self::STATUS_FAILED => 'danger',
                self::STATUS_CANCELLED => 'secondary',
                default => 'secondary',
            },
        );
    }

    /**
     * Get the formatted type display.
     */
    protected function typeDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->type) {
                self::TYPE_PAYMENT => 'Payment',
                self::TYPE_REFUND => 'Refund',
                self::TYPE_CHARGEBACK => 'Chargeback',
                self::TYPE_FEE => 'Fee',
                self::TYPE_ADJUSTMENT => 'Adjustment',
                default => ucfirst($this->type ?? 'Unknown'),
            },
        );
    }

    /**
     * Get the formatted status display.
     */
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_PENDING => 'Pending',
                self::STATUS_COMPLETED => 'Completed',
                self::STATUS_FAILED => 'Failed',
                self::STATUS_CANCELLED => 'Cancelled',
                default => ucfirst($this->status ?? 'Unknown'),
            },
        );
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include specific transaction type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include payments.
     */
    public function scopePayments($query)
    {
        return $query->where('type', self::TYPE_PAYMENT);
    }

    /**
     * Scope a query to only include refunds.
     */
    public function scopeRefunds($query)
    {
        return $query->where('type', self::TYPE_REFUND);
    }
}
