<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class HostingAccount extends Model
{
    /**
     * Boot the model and register event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        // Validate server capacity before creating
        static::creating(function ($hostingAccount) {
            if ($hostingAccount->server_id) {
                $server = Server::find($hostingAccount->server_id);
                if ($server && !$server->hasCapacity()) {
                    throw new \Exception("Server '{$server->name}' has reached maximum capacity ({$server->max_accounts} accounts).");
                }
            }
        });

        // When a hosting account is created, increment server account count
        static::created(function ($hostingAccount) {
            if ($hostingAccount->server_id) {
                $hostingAccount->server()->increment('current_accounts');
            }
        });

        // When a hosting account is deleted, decrement server account count
        static::deleted(function ($hostingAccount) {
            if ($hostingAccount->server_id) {
                $hostingAccount->server()->decrement('current_accounts');
            }
        });

        // When server_id changes, update both old and new servers
        static::updated(function ($hostingAccount) {
            if ($hostingAccount->isDirty('server_id')) {
                $oldServerId = $hostingAccount->getOriginal('server_id');
                $newServerId = $hostingAccount->server_id;

                // Decrement old server
                if ($oldServerId) {
                    Server::where('id', $oldServerId)->decrement('current_accounts');
                }

                // Increment new server
                if ($newServerId) {
                    Server::where('id', $newServerId)->increment('current_accounts');
                }
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
        'server_id',
        'product_id',
        'subscription_id',
        'order_id',
        'domain_registration_id',
        'account_number',
        'username',
        'domain',
        'password',
        'status',
        'suspension_reason',
        'provisioned_at',
        'suspended_at',
        'terminated_at',
        'disk_usage_mb',
        'bandwidth_usage_mb',
        'email_accounts',
        'databases',
        'subdomains',
        'cpanel_username',
        'cpanel_password',
        'cpanel_domain',
        'control_panel_config',
        'backup_enabled',
        'last_backup',
        'ssl_enabled',
        'ssl_type',
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
        'provisioned_at' => 'datetime',
        'suspended_at' => 'datetime',
        'terminated_at' => 'datetime',
        'last_backup' => 'datetime',
        'disk_usage_mb' => 'decimal:2',
        'bandwidth_usage_mb' => 'decimal:2',
        'email_accounts' => 'integer',
        'databases' => 'integer',
        'subdomains' => 'integer',
        'backup_enabled' => 'boolean',
        'ssl_enabled' => 'boolean',
        'control_panel_config' => 'array',
        'metadata' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'cpanel_password',
        'control_panel_config',
    ];

    /**
     * Get the customer that owns the hosting account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the server this account is hosted on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Get the product this account is based on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subscription associated with this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the order that created this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the domain registration for this hosting account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domainRegistration(): BelongsTo
    {
        return $this->belongsTo(DomainRegistration::class);
    }

    /**
     * Get the setup fee from the subscription.
     */
    protected function setupFee(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subscription?->setup_fee ?? 0,
        );
    }

    /**
     * Get the monthly fee from the subscription.
     */
    protected function monthlyFee(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subscription?->recurring_amount ?? 0,
        );
    }

    /**
     * Get the billing cycle from the subscription.
     */
    protected function billingCycle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subscription?->billing_cycle ?? 'monthly',
        );
    }

    /**
     * Get the next due date from the subscription.
     */
    protected function nextDueDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->subscription?->next_billing_date,
        );
    }

    /**
     * Get disk limit from product features (in MB).
     */
    protected function diskLimitMb(): Attribute
    {
        return Attribute::make(
            get: function () {
                $feature = $this->product?->features()
                    ->where('feature_key', 'disk_space')
                    ->first();

                if (!$feature) return $this->attributes['disk_limit_mb'] ?? null;

                if ($feature->feature_value === 'unlimited') return null;

                // Convert GB to MB
                return (float) $feature->feature_value * 1024;
            },
        );
    }

    /**
     * Get email limit from product features.
     */
    protected function emailLimit(): Attribute
    {
        return Attribute::make(
            get: function () {
                $feature = $this->product?->features()
                    ->where('feature_key', 'email_accounts')
                    ->first();

                if (!$feature) return $this->attributes['email_limit'] ?? null;

                if ($feature->feature_value === 'unlimited') return null;

                return (int) $feature->feature_value;
            },
        );
    }

    /**
     * Get database limit from product features.
     */
    protected function databaseLimit(): Attribute
    {
        return Attribute::make(
            get: function () {
                $feature = $this->product?->features()
                    ->where('feature_key', 'mysql_databases')
                    ->first();

                if (!$feature) return $this->attributes['database_limit'] ?? null;

                if ($feature->feature_value === 'unlimited') return null;

                return (int) $feature->feature_value;
            },
        );
    }

    /**
     * Get subdomain limit from product features.
     */
    protected function subdomainLimit(): Attribute
    {
        return Attribute::make(
            get: function () {
                $feature = $this->product?->features()
                    ->where('feature_key', 'websites_included')
                    ->first();

                if (!$feature) return $this->attributes['subdomain_limit'] ?? null;

                if ($feature->feature_value === 'unlimited') return null;

                return (int) $feature->feature_value;
            },
        );
    }

    /**
     * Get the account's display name with domain and status.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->username}@{$this->domain} ({$this->status_display})",
        );
    }

    /**
     * Get the formatted account status display name.
     */
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'pending' => 'Pending Setup',
                'active' => 'Active',
                'suspended' => 'Suspended',
                'terminated' => 'Terminated',
                'cancelled' => 'Cancelled',
                default => ucfirst($this->status),
            },
        );
    }

    /**
     * Get the disk usage percentage.
     */
    protected function diskUsagePercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->disk_limit_mb > 0
                ? round(($this->disk_usage_mb / $this->disk_limit_mb) * 100, 2)
                : 0,
        );
    }

    /**
     * Get the bandwidth usage percentage.
     */
    protected function bandwidthUsagePercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->bandwidth_limit_mb > 0
                ? round(($this->bandwidth_usage_mb / $this->bandwidth_limit_mb) * 100, 2)
                : 0,
        );
    }

    /**
     * Get the formatted disk usage display.
     */
    protected function diskUsageDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                $used = $this->formatBytes($this->disk_usage_mb * 1024 * 1024);
                $limit = $this->disk_limit_mb ? $this->formatBytes($this->disk_limit_mb * 1024 * 1024) : 'Unlimited';
                return "{$used} / {$limit}";
            },
        );
    }

    /**
     * Get the formatted bandwidth usage display.
     */
    protected function bandwidthUsageDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                $used = $this->formatBytes($this->bandwidth_usage_mb * 1024 * 1024);
                $limit = $this->bandwidth_limit_mb ? $this->formatBytes($this->bandwidth_limit_mb * 1024 * 1024) : 'Unlimited';
                return "{$used} / {$limit}";
            },
        );
    }

    /**
     * Encrypt the password when setting.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Encrypt the cPanel password when setting.
     */
    protected function cpanelPassword(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Scope a query to only include active accounts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include suspended accounts.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope a query to accounts due for renewal.
     */
    public function scopeDueForRenewal($query, $days = 7)
    {
        return $query->where('next_due_date', '<=', Carbon::now()->addDays($days));
    }

    /**
     * Check if account is overdue for payment.
     */
    public function isOverdue(): bool
    {
        return $this->next_due_date && $this->next_due_date->isPast();
    }

    /**
     * Check if account is approaching disk limit.
     */
    public function isApproachingDiskLimit($threshold = 80): bool
    {
        return $this->disk_usage_percentage >= $threshold;
    }

    /**
     * Check if account is approaching bandwidth limit.
     */
    public function isApproachingBandwidthLimit($threshold = 80): bool
    {
        return $this->bandwidth_usage_percentage >= $threshold;
    }

    /**
     * Validate if account can create more email accounts.
     */
    public function canCreateEmailAccount(): bool
    {
        $limit = $this->email_limit;
        return $limit === null || $this->email_accounts < $limit;
    }

    /**
     * Validate if account can create more databases.
     */
    public function canCreateDatabase(): bool
    {
        $limit = $this->database_limit;
        return $limit === null || $this->databases < $limit;
    }

    /**
     * Validate if account can create more subdomains.
     */
    public function canCreateSubdomain(): bool
    {
        $limit = $this->subdomain_limit;
        return $limit === null || $this->subdomains < $limit;
    }

    /**
     * Check if account is exceeding any product limits.
     */
    public function isExceedingLimits(): array
    {
        $violations = [];

        // Check disk limit
        $diskLimit = $this->disk_limit_mb;
        if ($diskLimit && $this->disk_usage_mb > $diskLimit) {
            $violations[] = 'disk_space';
        }

        // Check email limit
        $emailLimit = $this->email_limit;
        if ($emailLimit && $this->email_accounts > $emailLimit) {
            $violations[] = 'email_accounts';
        }

        // Check database limit
        $databaseLimit = $this->database_limit;
        if ($databaseLimit && $this->databases > $databaseLimit) {
            $violations[] = 'databases';
        }

        // Check subdomain limit
        $subdomainLimit = $this->subdomain_limit;
        if ($subdomainLimit && $this->subdomains > $subdomainLimit) {
            $violations[] = 'subdomains';
        }

        return $violations;
    }

    /**
     * Format bytes into human readable format.
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Generate a unique account number.
     */
    public static function generateAccountNumber(): string
    {
        do {
            $number = 'HA' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('account_number', $number)->exists());

        return $number;
    }

    /**
     * Find an available server for a product.
     */
    public static function findAvailableServer($productId): ?Server
    {
        $product = Product::find($productId);
        if (!$product || !$product->server_group_id) {
            return null;
        }

        // Find servers in the product's server group with available capacity
        return Server::where('server_group_id', $product->server_group_id)
            ->where('status', 'active')
            ->available() // Uses the scope we defined
            ->orderBy('current_accounts', 'asc') // Prefer servers with fewer accounts
            ->first();
    }
}
