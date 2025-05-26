<?php

namespace App\Support;

class StatusDisplayHelper
{
    /**
     * Generate Nova status badge HTML with custom styling.
     */
    public static function badge(string $status, string $label = null): string
    {
        $label = $label ?? ucfirst(str_replace('_', ' ', $status));
        $color = self::getStatusColor($status);
        $emoji = self::getStatusEmoji($status);
        
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800\">
                    {$emoji} {$label}
                </span>";
    }

    /**
     * Get status color class.
     */
    public static function getStatusColor(string $status): string
    {
        return match($status) {
            'active', 'paid', 'completed', 'resolved', 'closed' => 'green',
            'pending', 'processing', 'in_progress', 'open' => 'yellow',
            'failed', 'overdue', 'suspended', 'expired' => 'red',
            'cancelled', 'draft', 'inactive' => 'gray',
            'sent', 'refunded', 'transferred' => 'blue',
            default => 'gray',
        };
    }

    /**
     * Get status emoji.
     */
    public static function getStatusEmoji(string $status): string
    {
        return match($status) {
            'active', 'paid', 'completed', 'resolved', 'closed' => '🟢',
            'pending', 'processing', 'in_progress', 'open' => '🟡',
            'failed', 'overdue', 'suspended', 'expired' => '🔴',
            'cancelled', 'draft', 'inactive' => '⚪',
            'sent', 'refunded', 'transferred' => '🔵',
            default => '⚫',
        };
    }
}
