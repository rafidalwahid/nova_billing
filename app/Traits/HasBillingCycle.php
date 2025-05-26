<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasBillingCycle
{
    /**
     * Get the formatted billing cycle display.
     */
    protected function billingCycleDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getBillingCycleDisplay($this->billing_cycle)
        );
    }

    /**
     * Get display text for a billing cycle.
     */
    protected function getBillingCycleDisplay(string $billingCycle): string
    {
        return match($billingCycle) {
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly (3 months)',
            'semi_annually' => 'Semi-Annually (6 months)',
            'annually' => 'Annually (12 months)',
            'biennially' => 'Biennially (24 months)',
            'triennially' => 'Triennially (36 months)',
            'one_time' => 'One Time',
            default => ucfirst(str_replace('_', ' ', $billingCycle)),
        };
    }

    /**
     * Get billing cycle duration in months.
     */
    protected function billingCycleMonths(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getBillingCycleMonths($this->billing_cycle)
        );
    }

    /**
     * Get number of months for a billing cycle.
     */
    protected function getBillingCycleMonths(string $billingCycle): int
    {
        return match($billingCycle) {
            'monthly' => 1,
            'quarterly' => 3,
            'semi_annually' => 6,
            'annually' => 12,
            'biennially' => 24,
            'triennially' => 36,
            default => 1,
        };
    }
}
