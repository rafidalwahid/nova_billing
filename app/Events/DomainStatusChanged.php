<?php

namespace App\Events;

use App\Models\DomainRegistration;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DomainStatusChanged
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public DomainRegistration $domain,
        public string $oldStatus,
        public string $newStatus
    ) {
        //
    }
}
