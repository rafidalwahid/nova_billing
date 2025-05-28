<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ticket;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix existing ticket numbering to ensure consistency
        $this->fixExistingTicketNumbers();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed - this is a data fix migration
    }

    /**
     * Fix existing ticket numbers to use consistent sequential format.
     */
    private function fixExistingTicketNumbers(): void
    {
        // Get all tickets ordered by ID
        $tickets = Ticket::orderBy('id')->get();

        foreach ($tickets as $index => $ticket) {
            $sequentialNumber = $index + 1;
            $newTicketNumber = 'TKT-' . str_pad($sequentialNumber, 6, '0', STR_PAD_LEFT);

            // Only update if the ticket number doesn't match the expected format
            if ($ticket->ticket_number !== $newTicketNumber) {
                $ticket->update(['ticket_number' => $newTicketNumber]);

                echo "Updated ticket ID {$ticket->id}: {$ticket->ticket_number} -> {$newTicketNumber}\n";
            }
        }

        echo "Ticket numbering consistency fix completed.\n";
    }
};
