<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ServerGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'fill_method',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products assigned to this server group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the servers in this group (for future implementation).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers(): HasMany
    {
        // This will be implemented in Phase 6: Hosting Management
        return $this->hasMany(Server::class);
    }

    /**
     * Get the formatted fill method display name.
     */
    protected function fillMethodDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->fill_method) {
                'round_robin' => 'Round Robin',
                'least_used' => 'Least Used',
                'manual' => 'Manual Assignment',
                default => ucfirst(str_replace('_', ' ', $this->fill_method)),
            },
        );
    }

    /**
     * Scope a query to only include active server groups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the product count for this server group.
     */
    protected function productCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products()->count(),
        );
    }
}
