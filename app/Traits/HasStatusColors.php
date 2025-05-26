<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatusColors
{
    /**
     * Get the status badge color for Nova.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getStatusColor($this->status)
        );
    }

    /**
     * Get the status display with formatting.
     */
    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getStatusDisplay($this->status)
        );
    }

    /**
     * Get color for a given status.
     */
    protected function getStatusColor(string $status): string
    {
        // Default status colors - can be overridden in models
        return match($status) {
            'active', 'paid', 'completed', 'resolved', 'closed' => 'success',
            'pending', 'processing', 'in_progress', 'open' => 'warning',
            'failed', 'overdue', 'suspended', 'expired' => 'danger',
            'cancelled', 'draft', 'inactive' => 'secondary',
            'sent', 'refunded', 'transferred' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Get display text for a given status.
     */
    protected function getStatusDisplay(string $status): string
    {
        // Default status displays - can be overridden in models
        return match($status) {
            'in_progress' => 'In Progress',
            'semi_annually' => 'Semi-Annually',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }
}
