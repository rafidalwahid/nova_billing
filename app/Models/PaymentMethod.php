<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gateway',
        'is_active',
        'display_order',
        'config',
        'description',
        'icon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * Get the payments for this payment method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the display name with status.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name . ($this->is_active ? '' : ' (Inactive)'),
        );
    }

    /**
     * Get the status badge color.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_active ? 'success' : 'danger',
        );
    }

    /**
     * Get the gateway display name.
     */
    protected function gatewayDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->gateway) {
                'stripe' => 'Stripe',
                'paypal' => 'PayPal',
                'manual' => 'Manual',
                'bank_transfer' => 'Bank Transfer',
                'check' => 'Check',
                'cash' => 'Cash',
                default => ucfirst($this->gateway ?? 'Unknown'),
            },
        );
    }

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    /**
     * Scope a query to only include specific gateway.
     */
    public function scopeForGateway($query, $gateway)
    {
        return $query->where('gateway', $gateway);
    }
}
