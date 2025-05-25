<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketResponse extends Model
{
    // Response type constants
    const TYPE_CUSTOMER = 'customer';
    const TYPE_STAFF = 'staff';
    const TYPE_INTERNAL = 'internal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'user_id',
        'admin_user_id',
        'type',
        'message',
        'is_internal',
        'attachments',
        'response_time_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_internal' => 'boolean',
        'attachments' => 'array',
        'response_time_minutes' => 'integer',
    ];

    /**
     * Get the ticket that owns the response.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user that created the response (for customer responses).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user that created the response (for staff responses).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class);
    }

    /**
     * Get the author of the response (either user or admin user).
     */
    public function getAuthorAttribute()
    {
        if ($this->type === self::TYPE_CUSTOMER && $this->user) {
            return $this->user->userable; // Get the Customer model
        }

        if (in_array($this->type, [self::TYPE_STAFF, self::TYPE_INTERNAL]) && $this->adminUser) {
            return $this->adminUser;
        }

        return null;
    }

    /**
     * Get the author name.
     */
    public function getAuthorNameAttribute()
    {
        $author = $this->getAuthorAttribute();

        if ($author) {
            return $author->full_name ?? $author->name ?? 'Unknown';
        }

        return 'Unknown';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($response) {
            $ticket = $response->ticket;

            if ($ticket) {
                $updateData = [
                    'last_response_at' => now(),
                ];

                // If this is the first response, set first_response_at
                if (!$ticket->first_response_at && !$response->is_internal) {
                    $updateData['first_response_at'] = now();

                    // Calculate and store response time
                    $response->update([
                        'response_time_minutes' => $ticket->created_at->diffInMinutes(now())
                    ]);
                }

                $ticket->update($updateData);
            }
        });
    }
}
