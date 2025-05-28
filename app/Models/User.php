<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'userable_id',
        'userable_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the related profile model (Customer or AdminUser).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->userable_type === Customer::class;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->userable_type === AdminUser::class;
    }

    /**
     * Get the user's display name for Nova header.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->userable) {
            if ($this->isCustomer() || $this->isAdmin()) {
                return $this->userable->first_name . ' ' . $this->userable->last_name;
            }
        }

        return $this->name ?? 'User';
    }

    /**
     * Get the user's avatar URL for Nova header.
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->isCustomer() && $this->userable && $this->userable->profile_image) {
            return Storage::disk('public')->url('avatars/' . $this->userable->profile_image);
        }

        // Fallback to Gravatar
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=mp&s=40';
    }

    /**
     * Get the user's name for Nova display.
     * This method is used by Nova for user display.
     *
     * @return string
     */
    public function getNameAttribute($value): string
    {
        // If we have a polymorphic relationship, use the full name
        if ($this->userable) {
            if ($this->isCustomer() || $this->isAdmin()) {
                return $this->userable->first_name . ' ' . $this->userable->last_name;
            }
        }

        // Fallback to the stored name value
        return $value ?? 'User';
    }
}
