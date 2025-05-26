<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invoice extends Model
{
    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_SENT = 'sent';
    const STATUS_PAID = 'paid';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'order_id',
        'subscription_id',
        'invoice_number',
        'status',
        'subtotal',
        'tax_amount',
        'total',
        'balance_due',
        'currency',
        'invoice_date',
        'due_date',
        'paid_date',
        'notes',
        'terms',
    ];

    /**
     * Boot the model and register event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Validate business rules before saving
        static::saving(function ($invoice) {
            // Ensure no negative amounts
            if ($invoice->subtotal < 0) {
                throw new \InvalidArgumentException('Invoice subtotal cannot be negative');
            }
            if ($invoice->tax_amount < 0) {
                throw new \InvalidArgumentException('Invoice tax amount cannot be negative');
            }
            if ($invoice->total < 0) {
                throw new \InvalidArgumentException('Invoice total cannot be negative');
            }
            if ($invoice->balance_due < 0) {
                throw new \InvalidArgumentException('Invoice balance due cannot be negative');
            }

            // Validate status transitions
            if ($invoice->exists && $invoice->isDirty('status')) {
                $oldStatus = $invoice->getOriginal('status');
                $newStatus = $invoice->status;

                if (!$invoice->isValidStatusTransition($oldStatus, $newStatus)) {
                    throw new \InvalidArgumentException("Invalid status transition from {$oldStatus} to {$newStatus}");
                }
            }

            // Set paid_date when status changes to paid
            if ($invoice->status === self::STATUS_PAID && !$invoice->paid_date) {
                $invoice->paid_date = now();
            }

            // Clear paid_date when status changes from paid
            if ($invoice->status !== self::STATUS_PAID && $invoice->paid_date) {
                $invoice->paid_date = null;
            }
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * Get the customer that owns the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order that this invoice is based on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the subscription that this invoice is based on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the invoice lines for the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    /**
     * Get the payments for the invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the formatted invoice number.
     */
    protected function formattedInvoiceNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get the status badge color.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_DRAFT => 'secondary',
                self::STATUS_SENT => 'info',
                self::STATUS_PAID => 'success',
                self::STATUS_OVERDUE => 'danger',
                self::STATUS_CANCELLED => 'warning',
                default => 'secondary',
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
                self::STATUS_DRAFT => 'Draft',
                self::STATUS_SENT => 'Sent',
                self::STATUS_PAID => 'Paid',
                self::STATUS_OVERDUE => 'Overdue',
                self::STATUS_CANCELLED => 'Cancelled',
                default => ucfirst($this->status ?? 'Unknown'),
            },
        );
    }

    /**
     * Check if the invoice is overdue.
     */
    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status !== self::STATUS_PAID &&
                         $this->status !== self::STATUS_CANCELLED &&
                         $this->due_date < now()->toDateString(),
        );
    }

    /**
     * Check if the invoice is paid.
     */
    protected function isPaid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === self::STATUS_PAID,
        );
    }

    /**
     * Scope a query to only include invoices with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    /**
     * Scope a query to only include overdue invoices.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', self::STATUS_PAID)
                    ->where('status', '!=', self::STATUS_CANCELLED)
                    ->where('due_date', '<', now()->toDateString());
    }

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', '!=', self::STATUS_PAID)
                    ->where('status', '!=', self::STATUS_CANCELLED);
    }

    /**
     * Validate status transitions.
     */
    public function isValidStatusTransition(string $oldStatus, string $newStatus): bool
    {
        $validTransitions = [
            self::STATUS_DRAFT => [self::STATUS_SENT, self::STATUS_CANCELLED],
            self::STATUS_SENT => [self::STATUS_PAID, self::STATUS_OVERDUE, self::STATUS_CANCELLED],
            self::STATUS_PAID => [], // Paid invoices cannot change status
            self::STATUS_OVERDUE => [self::STATUS_PAID, self::STATUS_CANCELLED],
            self::STATUS_CANCELLED => [], // Cancelled invoices cannot change status
        ];

        return in_array($newStatus, $validTransitions[$oldStatus] ?? []);
    }

    /**
     * Calculate balance due based on total payments.
     */
    public function calculateBalanceDue(): float
    {
        $totalPayments = $this->payments()->sum('amount');
        return max(0, $this->total - $totalPayments);
    }

    /**
     * Update balance due based on payments.
     */
    public function updateBalanceDue(): void
    {
        $this->balance_due = $this->calculateBalanceDue();
        $this->save();
    }
}
