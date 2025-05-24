<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'description',
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
     * Get the product's pricing tiers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pricing(): HasMany
    {
        return $this->hasMany(ProductPricing::class);
    }

    /**
     * Get the product's display name with type.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->name} ({$this->type})",
        );
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include products of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
