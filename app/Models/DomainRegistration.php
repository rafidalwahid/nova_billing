<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class DomainRegistration extends Model
{
    /**
     * Boot the model and register event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Validate and auto-calculate dates before creating
        static::creating(function ($domain) {
            // Prevent future registration dates
            if ($domain->registration_date && Carbon::parse($domain->registration_date)->isFuture()) {
                throw new \InvalidArgumentException('Registration date cannot be in the future');
            }

            // Auto-calculate expiration if not set
            if (!$domain->expiration_date && $domain->registration_date && $domain->registration_period) {
                $domain->expiration_date = Carbon::parse($domain->registration_date)
                    ->addYears($domain->registration_period);
            }

            // Set default registration date if not provided
            if (!$domain->registration_date) {
                $domain->registration_date = Carbon::now();
            }
        });

        // Validate dates before updating
        static::updating(function ($domain) {
            if ($domain->isDirty('registration_date') &&
                $domain->registration_date &&
                Carbon::parse($domain->registration_date)->isFuture()) {
                throw new \InvalidArgumentException('Registration date cannot be in the future');
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'product_id',
        'subscription_id',
        'order_id',
        'domain_name',
        'tld',
        'registrar',
        'status',
        'registration_date',
        'expiration_date',
        'registration_period',
        'registrar_domain_id',
        'registrar_config',
        'auth_code',
        'nameservers',
        'dns_management',
        'whois_privacy',
        'registrant_contact',
        'admin_contact',
        'tech_contact',
        'billing_contact',
        'auto_renew',
        'registration_fee',
        'renewal_fee',
        'next_due_date',
        'transfer_lock',
        'transfer_requested_at',
        'transfer_status',
        'email_forwarding',
        'url_forwarding',
        'additional_services',
        'metadata',
        'notes',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'registration_date' => 'date',
        'expiration_date' => 'date',
        'next_due_date' => 'date',
        'transfer_requested_at' => 'datetime',
        'registration_period' => 'integer',
        'registration_fee' => 'decimal:2',
        'renewal_fee' => 'decimal:2',
        'dns_management' => 'boolean',
        'whois_privacy' => 'boolean',
        'auto_renew' => 'boolean',
        'transfer_lock' => 'boolean',
        'email_forwarding' => 'boolean',
        'url_forwarding' => 'boolean',
        'nameservers' => 'array',
        'registrant_contact' => 'array',
        'admin_contact' => 'array',
        'tech_contact' => 'array',
        'billing_contact' => 'array',
        'registrar_config' => 'array',
        'additional_services' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the customer that owns the domain.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the product this domain is based on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subscription associated with this domain.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the order that created this domain registration.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the computed status based on real-time conditions.
     */
    protected function computedStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Real-time status based on dates and conditions
                if ($this->expiration_date && $this->expiration_date->isPast()) {
                    return 'expired';
                }

                if ($this->suspended_at) {
                    return 'suspended';
                }

                if ($this->status === 'cancelled') {
                    return 'cancelled';
                }

                if ($this->transfer_requested_at && $this->transfer_status === 'pending') {
                    return 'pending';
                }

                return $this->status === 'pending' ? 'pending' : 'active';
            },
        );
    }

    /**
     * Get the domain's display name with TLD and computed status.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->domain_name} ({$this->computed_status_display})",
        );
    }

    /**
     * Get the computed status display name.
     */
    protected function computedStatusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->computed_status) {
                'pending' => 'Pending Registration',
                'active' => 'Active',
                'expired' => 'Expired',
                'suspended' => 'Suspended',
                'cancelled' => 'Cancelled',
                'transferred' => 'Transferred Out',
                default => ucfirst($this->computed_status),
            },
        );
    }

    /**
     * Get the full domain name with TLD.
     */
    protected function fullDomain(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->domain_name . $this->tld,
        );
    }

    /**
     * Get the formatted domain status display name.
     */
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'pending' => 'Pending Registration',
                'active' => 'Active',
                'expired' => 'Expired',
                'suspended' => 'Suspended',
                'cancelled' => 'Cancelled',
                'transferred' => 'Transferred Out',
                default => ucfirst($this->status),
            },
        );
    }

    /**
     * Get the formatted registrar display name.
     */
    protected function registrarDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->registrar) {
                'namecheap' => 'Namecheap',
                'godaddy' => 'GoDaddy',
                'cloudflare' => 'Cloudflare',
                'enom' => 'eNom',
                'namesilo' => 'NameSilo',
                default => ucfirst($this->registrar),
            },
        );
    }

    /**
     * Get the days until expiration (negative if expired).
     */
    protected function daysUntilExpiration(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expiration_date
                ? (int) Carbon::now()->diffInDays($this->expiration_date, false)
                : null,
        );
    }

    /**
     * Get human-readable expiration status.
     */
    protected function expirationStatusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->expiration_date) return 'No expiration date';

                $days = (int) $this->days_until_expiration;

                if ($days < 0) {
                    $absDays = abs($days);
                    return 'Expired ' . $absDays . ' day' . ($absDays !== 1 ? 's' : '') . ' ago';
                }

                if ($days == 0) {
                    return 'Expires today';
                }

                if ($days <= 30) {
                    return 'Expires in ' . $days . ' day' . ($days !== 1 ? 's' : '');
                }

                return 'Expires ' . $this->expiration_date->format('M j, Y');
            },
        );
    }

    /**
     * Get the expiration status with color coding.
     */
    protected function expirationStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->expiration_date) return 'unknown';

                $days = (int) $this->days_until_expiration;

                if ($days < 0) return 'expired';
                if ($days <= 7) return 'critical';
                if ($days <= 30) return 'warning';
                if ($days <= 60) return 'notice';
                return 'good';
            },
        );
    }

    /**
     * Scope a query to only include active domains.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include expired domains.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope a query to domains expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiration_date', '<=', Carbon::now()->addDays($days))
                    ->where('expiration_date', '>', Carbon::now());
    }

    /**
     * Scope a query to domains due for renewal.
     */
    public function scopeDueForRenewal($query, $days = 7)
    {
        return $query->where('next_due_date', '<=', Carbon::now()->addDays($days));
    }

    /**
     * Scope a query by registrar.
     */
    public function scopeByRegistrar($query, $registrar)
    {
        return $query->where('registrar', $registrar);
    }

    /**
     * Scope a query by TLD.
     */
    public function scopeByTld($query, $tld)
    {
        return $query->where('tld', $tld);
    }

    /**
     * Check if domain is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    /**
     * Check if domain is expiring soon.
     */
    public function isExpiringSoon($days = 30): bool
    {
        return $this->expiration_date &&
               $this->expiration_date->isBefore(Carbon::now()->addDays($days)) &&
               $this->expiration_date->isFuture();
    }

    /**
     * Check if domain is overdue for renewal payment.
     */
    public function isOverdue(): bool
    {
        return $this->next_due_date && $this->next_due_date->isPast();
    }

    /**
     * Check if domain has privacy protection enabled.
     */
    public function hasPrivacyProtection(): bool
    {
        return $this->whois_privacy;
    }

    /**
     * Check if domain is locked for transfers.
     */
    public function isTransferLocked(): bool
    {
        return $this->transfer_lock;
    }

    /**
     * Get the default nameservers for the registrar.
     */
    public function getDefaultNameservers(): array
    {
        return match($this->registrar) {
            'namecheap' => [
                'dns1.registrar-servers.com',
                'dns2.registrar-servers.com',
            ],
            'godaddy' => [
                'ns1.domaincontrol.com',
                'ns2.domaincontrol.com',
            ],
            'cloudflare' => [
                'ns1.cloudflare.com',
                'ns2.cloudflare.com',
            ],
            default => [],
        };
    }

    /**
     * Calculate the renewal date based on registration period.
     */
    public function calculateRenewalDate(): Carbon
    {
        return $this->expiration_date
            ? $this->expiration_date->copy()->addYears($this->registration_period)
            : Carbon::now()->addYears($this->registration_period);
    }
}
