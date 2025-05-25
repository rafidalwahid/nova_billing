<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'server_group_id',
        'name',
        'hostname',
        'ip_address',
        'port',
        'type',
        'os',
        'control_panel',
        'username',
        'password',
        'ssh_key',
        'status',
        'is_monitored',
        'last_ping',
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'uptime_seconds',
        'max_accounts',
        'current_accounts',
        'monthly_bandwidth_gb',
        'disk_space_gb',
        'api_config',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_monitored' => 'boolean',
        'last_ping' => 'datetime',
        'cpu_usage' => 'decimal:2',
        'memory_usage' => 'decimal:2',
        'disk_usage' => 'decimal:2',
        'uptime_seconds' => 'integer',
        'max_accounts' => 'integer',
        'current_accounts' => 'integer',
        'monthly_bandwidth_gb' => 'decimal:2',
        'disk_space_gb' => 'decimal:2',
        'api_config' => 'array',
        'port' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'ssh_key',
        'api_config',
    ];

    /**
     * Get the server group this server belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serverGroup(): BelongsTo
    {
        return $this->belongsTo(ServerGroup::class);
    }

    /**
     * Get the hosting accounts on this server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hostingAccounts(): HasMany
    {
        return $this->hasMany(HostingAccount::class);
    }

    /**
     * Get the server's display name with type and status.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->name} ({$this->hostname}) - " . ucfirst($this->type),
        );
    }

    /**
     * Get the formatted server type display name.
     */
    protected function typeDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->type) {
                'shared' => 'Shared Hosting',
                'vps' => 'VPS Server',
                'dedicated' => 'Dedicated Server',
                'cloud' => 'Cloud Server',
                default => ucfirst($this->type),
            },
        );
    }

    /**
     * Get the formatted OS display name.
     */
    protected function osDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->os) {
                'linux' => 'Linux',
                'windows' => 'Windows Server',
                'freebsd' => 'FreeBSD',
                default => ucfirst($this->os),
            },
        );
    }

    /**
     * Get the server status display with color coding.
     */
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'active' => 'Active',
                'inactive' => 'Inactive',
                'maintenance' => 'Under Maintenance',
                'suspended' => 'Suspended',
                default => ucfirst($this->status),
            },
        );
    }

    /**
     * Get the account utilization percentage.
     */
    protected function accountUtilization(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->max_accounts > 0
                ? round(($this->current_accounts / $this->max_accounts) * 100, 2)
                : 0,
        );
    }

    /**
     * Get the uptime in human readable format.
     */
    protected function uptimeDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->uptime_seconds) return 'Unknown';

                $days = floor($this->uptime_seconds / 86400);
                $hours = floor(($this->uptime_seconds % 86400) / 3600);
                $minutes = floor(($this->uptime_seconds % 3600) / 60);

                return "{$days}d {$hours}h {$minutes}m";
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
     * Encrypt the SSH key when setting.
     */
    protected function sshKey(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decryptString($value) : null,
            set: fn ($value) => $value ? Crypt::encryptString($value) : null,
        );
    }

    /**
     * Scope a query to only include active servers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include monitored servers.
     */
    public function scopeMonitored($query)
    {
        return $query->where('is_monitored', true);
    }

    /**
     * Scope a query to servers with available capacity.
     */
    public function scopeAvailable($query)
    {
        return $query->whereRaw('current_accounts < max_accounts');
    }

    /**
     * Check if server has available capacity.
     */
    public function hasCapacity(): bool
    {
        return $this->current_accounts < $this->max_accounts;
    }

    /**
     * Check if server is online (last ping within 5 minutes).
     */
    public function isOnline(): bool
    {
        return $this->last_ping && $this->last_ping->diffInMinutes(now()) <= 5;
    }

    /**
     * Get the server health status based on resource usage.
     */
    public function getHealthStatus(): string
    {
        $cpu = $this->cpu_usage ?? 0;
        $memory = $this->memory_usage ?? 0;
        $disk = $this->disk_usage ?? 0;

        $maxUsage = max($cpu, $memory, $disk);

        if ($maxUsage >= 90) return 'critical';
        if ($maxUsage >= 75) return 'warning';
        if ($maxUsage >= 50) return 'good';
        return 'excellent';
    }
}
