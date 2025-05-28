<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasStatusColors;

class Ticket extends Model
{
    use HasStatusColors;
    // Status constants
    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    // Priority constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    // Category constants
    const CATEGORY_BILLING = 'billing';
    const CATEGORY_TECHNICAL = 'technical';
    const CATEGORY_SALES = 'sales';
    const CATEGORY_GENERAL = 'general';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_number',
        'customer_id',
        'assigned_to',
        'department_id',
        'subject',
        'description',
        'status',
        'priority',
        'category',
        'source',
        'resolved_at',
        'closed_at',
        'first_response_at',
        'last_response_at',
        'sla_due_at',
        'tags',
        'internal_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'first_response_at' => 'datetime',
        'last_response_at' => 'datetime',
        'sla_due_at' => 'datetime',
        'tags' => 'array',
    ];

    /**
     * Get the customer that owns the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the staff member assigned to the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'assigned_to');
    }

    /**
     * Get the department that owns the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the ticket responses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }

    /**
     * Get the formatted ticket number.
     */
    protected function formattedTicketNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => 'TKT-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get all available statuses.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_RESOLVED => 'Resolved',
            self::STATUS_CLOSED => 'Closed',
        ];
    }

    /**
     * Get all available priorities.
     *
     * @return array
     */
    public static function getPriorities(): array
    {
        return [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];
    }

    /**
     * Get all available categories.
     *
     * @return array
     */
    public static function getCategories(): array
    {
        return [
            self::CATEGORY_BILLING => 'Billing',
            self::CATEGORY_TECHNICAL => 'Technical',
            self::CATEGORY_SALES => 'Sales',
            self::CATEGORY_GENERAL => 'General',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            // Only generate ticket number if not already provided
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = static::generateUniqueTicketNumber();
            }

            // Auto-assign department based on category
            if (empty($ticket->department_id) && !empty($ticket->category)) {
                $ticket->department_id = static::getDefaultDepartmentForCategory($ticket->category);
            }

            // Set SLA due date based on priority
            if (empty($ticket->sla_due_at) && !empty($ticket->priority)) {
                $ticket->sla_due_at = static::calculateSLADueDate($ticket->priority);
            }
        });

        static::updating(function ($ticket) {
            // Update timestamps based on status changes
            if ($ticket->isDirty('status')) {
                static::updateStatusTimestamps($ticket);
            }
        });
    }

    /**
     * Get default department ID for a given category.
     *
     * @param string $category
     * @return int|null
     */
    public static function getDefaultDepartmentForCategory(string $category): ?int
    {
        // Map categories to department names
        $departmentMapping = [
            self::CATEGORY_BILLING => 'Revenue Operations',
            self::CATEGORY_TECHNICAL => 'IT Operations',
            self::CATEGORY_SALES => 'Sales',
            self::CATEGORY_GENERAL => 'Customer Experience',
        ];

        $departmentName = $departmentMapping[$category] ?? 'Customer Experience';

        // Find department by name
        $department = Department::where('name', $departmentName)->first();

        return $department?->id;
    }

    /**
     * Calculate SLA due date based on priority.
     *
     * @param string $priority
     * @return \Carbon\Carbon
     */
    public static function calculateSLADueDate(string $priority): \Carbon\Carbon
    {
        $hours = match($priority) {
            self::PRIORITY_URGENT => 2,   // 2 hours
            self::PRIORITY_HIGH => 8,     // 8 hours
            self::PRIORITY_NORMAL => 24,  // 24 hours
            self::PRIORITY_LOW => 72,     // 72 hours
            default => 24,
        };

        return now()->addHours($hours);
    }

    /**
     * Update status timestamps when status changes.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public static function updateStatusTimestamps(Ticket $ticket): void
    {
        switch ($ticket->status) {
            case self::STATUS_RESOLVED:
                if (!$ticket->resolved_at) {
                    $ticket->resolved_at = now();
                }
                break;

            case self::STATUS_CLOSED:
                if (!$ticket->closed_at) {
                    $ticket->closed_at = now();
                }
                if (!$ticket->resolved_at) {
                    $ticket->resolved_at = now();
                }
                break;
        }
    }

    /**
     * Get tickets that are overdue based on SLA.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function overdue()
    {
        return static::where('sla_due_at', '<', now())
                    ->whereNotIn('status', [self::STATUS_RESOLVED, self::STATUS_CLOSED]);
    }

    /**
     * Get response time in minutes since ticket creation.
     *
     * @return int|null
     */
    public function getResponseTimeMinutes()
    {
        if ($this->first_response_at) {
            return $this->created_at->diffInMinutes($this->first_response_at);
        }

        return null;
    }

    /**
     * Check if ticket is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        return $this->sla_due_at &&
               $this->sla_due_at->isPast() &&
               !in_array($this->status, [self::STATUS_RESOLVED, self::STATUS_CLOSED]);
    }

    /**
     * Get the status badge color for Nova.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_RESOLVED, self::STATUS_CLOSED => 'success',
                self::STATUS_IN_PROGRESS => 'info',
                self::STATUS_OPEN => 'warning',
                default => 'secondary',
            },
        );
    }

    /**
     * Get the priority badge color for Nova.
     */
    protected function priorityColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->priority) {
                self::PRIORITY_URGENT => 'danger',
                self::PRIORITY_HIGH => 'warning',
                self::PRIORITY_NORMAL => 'info',
                self::PRIORITY_LOW => 'success',
                default => 'secondary',
            },
        );
    }

    /**
     * Generate a unique ticket number using atomic database operations.
     * This method ensures no duplicate ticket numbers across all creation methods.
     *
     * @return string
     */
    public static function generateUniqueTicketNumber(): string
    {
        return \DB::transaction(function () {
            // Get the next sequential number atomically
            $lastTicket = static::lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = $lastTicket ? $lastTicket->id + 1 : 1;

            // Generate ticket number with consistent format
            $ticketNumber = 'TKT-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Double-check uniqueness (safety net)
            while (static::where('ticket_number', $ticketNumber)->exists()) {
                $nextNumber++;
                $ticketNumber = 'TKT-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            }

            return $ticketNumber;
        });
    }
}
