<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Customer;
use App\Models\Ticket;

class DebugCustomerTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:customer-tickets {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug customer ticket relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'john.doe@customer.com';

        $this->info("Debugging customer tickets for: {$email}");
        $this->line('');

        // Find user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        $this->info("✓ User found:");
        $this->line("  ID: {$user->id}");
        $this->line("  Name: {$user->name}");
        $this->line("  Email: {$user->email}");
        $this->line("  Type: {$user->userable_type}");
        $this->line("  Is Customer: " . ($user->isCustomer() ? 'Yes' : 'No'));
        $this->line('');

        if (!$user->isCustomer()) {
            $this->error("User is not a customer!");
            return 1;
        }

        // Get customer
        $customer = $user->userable;
        $this->info("✓ Customer found:");
        $this->line("  ID: {$customer->id}");
        $this->line("  Name: {$customer->full_name}");
        $this->line('');

        // Check tickets
        $totalTickets = Ticket::count();
        $customerTickets = Ticket::where('customer_id', $customer->id)->get();

        $this->info("📊 Ticket Statistics:");
        $this->line("  Total tickets in database: {$totalTickets}");
        $this->line("  Tickets for this customer: {$customerTickets->count()}");
        $this->line('');

        if ($customerTickets->count() > 0) {
            $this->info("🎫 Customer's Tickets:");
            foreach ($customerTickets as $ticket) {
                $this->line("  #{$ticket->ticket_number} - {$ticket->subject} ({$ticket->status})");
            }
        } else {
            $this->warn("No tickets found for this customer.");

            // Show all tickets with customer info
            $this->info("🔍 All tickets in database:");
            $allTickets = Ticket::with('customer')->get();
            foreach ($allTickets as $ticket) {
                $customerName = $ticket->customer ? $ticket->customer->full_name : 'Unknown';
                $this->line("  #{$ticket->ticket_number} - Customer: {$customerName} (ID: {$ticket->customer_id})");
            }

            // Suggest fix
            $this->line('');
            $this->info("💡 To fix this, run:");
            $this->line("  php artisan db:seed --class=TicketSeeder");
        }

        return 0;
    }
}
