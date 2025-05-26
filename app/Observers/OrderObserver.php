<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "saving" event.
     */
    public function saving(Order $order): void
    {
        // Validate and auto-calculate order totals
        $this->validateAndCalculateTotals($order);
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        Log::info('Order created', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'customer_id' => $order->customer_id,
            'total' => $order->total,
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Log significant changes
        if ($order->wasChanged(['status', 'total'])) {
            Log::info('Order updated', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'changes' => $order->getChanges(),
            ]);
        }
    }

    /**
     * Validate and calculate order totals
     */
    private function validateAndCalculateTotals(Order $order): void
    {
        // Validate no negative amounts
        if ($order->subtotal < 0) {
            throw new \InvalidArgumentException('Order subtotal cannot be negative');
        }
        if ($order->tax_amount < 0) {
            throw new \InvalidArgumentException('Order tax amount cannot be negative');
        }

        // Auto-calculate total if not manually set
        if ($order->isDirty(['subtotal', 'tax_amount']) && !$order->isDirty('total')) {
            $order->total = $order->subtotal + $order->tax_amount;
        }

        // Validate total matches subtotal + tax
        $expectedTotal = $order->subtotal + $order->tax_amount;
        if (abs($order->total - $expectedTotal) > 0.01) { // Allow for small rounding differences
            throw new \InvalidArgumentException(
                "Order total ({$order->total}) does not match subtotal + tax ({$expectedTotal})"
            );
        }

        // Validate total is not negative
        if ($order->total < 0) {
            throw new \InvalidArgumentException('Order total cannot be negative');
        }
    }
}
