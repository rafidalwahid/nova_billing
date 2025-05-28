<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Auditable;

class Payment extends Model
{
    use Auditable;
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     * Restricted for security - sensitive fields like gateway_response should not be mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'payment_method_id',
        'amount',
        'payment_date',
        'status',
        'reference_number',
        'notes',
    ];

    /**
     * The attributes that should be guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded = [
        'gateway_transaction_id',
        'gateway_response',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the invoice that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the customer that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the payment method used for this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the transactions for this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the formatted payment reference.
     */
    protected function formattedReference(): Attribute
    {
        return Attribute::make(
            get: fn () => 'PAY-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get the status badge color for Nova.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_COMPLETED => 'success',
                self::STATUS_PENDING => 'warning',
                self::STATUS_FAILED => 'danger',
                self::STATUS_REFUNDED => 'info',
                self::STATUS_CANCELLED => 'secondary',
                default => 'secondary',
            },
        );
    }

    /**
     * Scope a query to only include completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }
}
