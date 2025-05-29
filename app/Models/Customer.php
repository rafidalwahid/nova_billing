<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Auditable;

class Customer extends Model
{
    use Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'company_name',
        'status',
        'last_login',
    ];

    /**
     * Get the customer's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'last_login' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // Ensure status is set
            if (is_null($customer->status)) {
                $customer->status = true;
            }
        });

        static::updating(function ($customer) {
            // Update last_login when status changes to active
            if ($customer->isDirty('status') && $customer->status) {
                $customer->last_login = now();
            }
        });
    }

    /**
     * Get the user record associated with the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include inactive customers.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to customers with recent activity.
     */
    public function scopeRecentlyActive($query, $days = 30)
    {
        return $query->where('last_login', '>=', now()->subDays($days));
    }

    /**
     * Check if customer is active.
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }

    /**
     * Check if customer has recent activity.
     */
    public function hasRecentActivity($days = 30): bool
    {
        return $this->last_login && $this->last_login->gte(now()->subDays($days));
    }

    /**
     * Get the tickets for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the orders for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the invoices for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the payments for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the transactions for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the subscriptions for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the hosting accounts for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hostingAccounts(): HasMany
    {
        return $this->hasMany(HostingAccount::class);
    }

    /**
     * Get the domain registrations for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domainRegistrations(): HasMany
    {
        return $this->hasMany(DomainRegistration::class);
    }

    // Ticket relationship removed - will be implemented later
}
