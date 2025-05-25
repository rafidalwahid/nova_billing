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
        'disk_limit_mb',
        'bandwidth_usage_mb',
        'bandwidth_limit_mb',
        'email_accounts',
        'email_limit',
        'databases',
        'database_limit',
        'subdomains',
        'subdomain_limit',
        'cpanel_username',
        'cpanel_password',
        'cpanel_domain',
        'control_panel_config',
        'backup_enabled',
        'last_backup',
        'ssl_enabled',
        'ssl_type',
        'setup_fee',
        'monthly_fee',
        'billing_cycle',
        'next_due_date',
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
        'next_due_date' => 'date',
        'disk_usage_mb' => 'decimal:2',
        'disk_limit_mb' => 'decimal:2',
        'bandwidth_usage_mb' => 'decimal:2',
        'bandwidth_limit_mb' => 'decimal:2',
        'email_accounts' => 'integer',
        'email_limit' => 'integer',
        'databases' => 'integer',
        'database_limit' => 'integer',
        'subdomains' => 'integer',
        'subdomain_limit' => 'integer',
        'backup_enabled' => 'boolean',
        'ssl_enabled' => 'boolean',
        'setup_fee' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
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
}
