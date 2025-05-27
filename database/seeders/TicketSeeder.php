<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\Customer;
use App\Models\AdminUser;
use App\Models\Department;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing customers and departments
        $customers = Customer::all();
        $departments = Department::all();
        $adminUsers = AdminUser::all();

        if ($customers->isEmpty() || $departments->isEmpty() || $adminUsers->isEmpty()) {
            $this->command->warn('Please run CustomerSeeder, DepartmentSeeder, and AdminUserSeeder first.');
            return;
        }

        // Get specific departments for realistic assignment
        $customerExpDept = Department::where('name', 'Customer Experience')->first();
        $revenueDept = Department::where('name', 'Revenue Operations')->first();
        $itDept = Department::where('name', 'Information Technology')->first();
        $salesDept = Department::where('name', 'Business Development')->first();

        // Get John Doe customer specifically for testing
        $johnDoe = $customers->where('first_name', 'John')->where('last_name', 'Doe')->first();
        if (!$johnDoe) {
            $johnDoe = $customers->first(); // Fallback to first customer
        }

        // Create realistic support tickets
        $tickets = [
            // Assign first two tickets specifically to John Doe for testing
            [
                'ticket_number' => 'TKT-000001',
                'customer_id' => $johnDoe->id,
                'assigned_to' => $adminUsers->where('department_id', $customerExpDept?->id)->first()?->id,
                'department_id' => $customerExpDept?->id,
                'subject' => 'Unable to access billing dashboard',
                'description' => 'I am unable to log into my billing dashboard. When I try to login, I get an error message saying "Invalid credentials" even though I am using the correct password.',
                'status' => Ticket::STATUS_OPEN,
                'priority' => Ticket::PRIORITY_HIGH,
                'category' => Ticket::CATEGORY_TECHNICAL,
                'source' => 'web',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'ticket_number' => 'TKT-000002',
                'customer_id' => $johnDoe->id,
                'assigned_to' => $adminUsers->where('department_id', $revenueDept?->id)->first()?->id,
                'department_id' => $revenueDept?->id,
                'subject' => 'Incorrect billing amount on latest invoice',
                'description' => 'My latest invoice shows a charge of $299.99 but my subscription plan should only be $199.99 per month. Please review and correct this billing error.',
                'status' => Ticket::STATUS_IN_PROGRESS,
                'priority' => Ticket::PRIORITY_URGENT,
                'category' => Ticket::CATEGORY_BILLING,
                'source' => 'email',
                'first_response_at' => now()->subDays(1)->subHours(2),
                'last_response_at' => now()->subHours(6),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subHours(6),
            ],
            [
                'ticket_number' => 'TKT-000003',
                'customer_id' => $customers->random()->id,
                'assigned_to' => $adminUsers->where('department_id', $salesDept->id)->first()?->id,
                'department_id' => $salesDept->id,
                'subject' => 'Inquiry about enterprise pricing plans',
                'description' => 'We are interested in upgrading to an enterprise plan for our growing team of 50+ users. Could you please provide information about enterprise pricing and features?',
                'status' => Ticket::STATUS_RESOLVED,
                'priority' => Ticket::PRIORITY_NORMAL,
                'category' => Ticket::CATEGORY_SALES,
                'source' => 'phone',
                'first_response_at' => now()->subDays(4)->subHours(1),
                'last_response_at' => now()->subDays(1),
                'resolved_at' => now()->subDays(1),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
            ],
            [
                'ticket_number' => 'TKT-000004',
                'customer_id' => $customers->random()->id,
                'assigned_to' => $adminUsers->where('department_id', $itDept->id)->first()?->id,
                'department_id' => $itDept->id,
                'subject' => 'Server downtime affecting our services',
                'description' => 'We experienced significant downtime yesterday from 2 PM to 4 PM EST. Our services were completely unavailable during this time. What caused this outage and what measures are being taken to prevent future occurrences?',
                'status' => Ticket::STATUS_CLOSED,
                'priority' => Ticket::PRIORITY_URGENT,
                'category' => Ticket::CATEGORY_TECHNICAL,
                'source' => 'web',
                'first_response_at' => now()->subDays(6)->subHours(1),
                'last_response_at' => now()->subDays(3),
                'resolved_at' => now()->subDays(4),
                'closed_at' => now()->subDays(3),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(3),
            ],
            [
                'ticket_number' => 'TKT-000005',
                'customer_id' => $customers->random()->id,
                'assigned_to' => $adminUsers->where('department_id', $customerExpDept->id)->first()?->id,
                'department_id' => $customerExpDept->id,
                'subject' => 'Request for account cancellation',
                'description' => 'I would like to cancel my account effective at the end of this billing cycle. Please confirm the cancellation process and any final charges.',
                'status' => Ticket::STATUS_OPEN,
                'priority' => Ticket::PRIORITY_NORMAL,
                'category' => Ticket::CATEGORY_GENERAL,
                'source' => 'email',
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(8),
            ],
            [
                'ticket_number' => 'TKT-000006',
                'customer_id' => $customers->random()->id,
                'assigned_to' => $adminUsers->where('department_id', $revenueDept->id)->first()?->id,
                'department_id' => $revenueDept->id,
                'subject' => 'Payment method update required',
                'description' => 'My credit card on file has expired and I need to update my payment method. However, I cannot find the option to update it in my account settings.',
                'status' => Ticket::STATUS_IN_PROGRESS,
                'priority' => Ticket::PRIORITY_HIGH,
                'category' => Ticket::CATEGORY_BILLING,
                'source' => 'web',
                'first_response_at' => now()->subHours(12),
                'last_response_at' => now()->subHours(4),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(4),
            ],
        ];

        foreach ($tickets as $ticketData) {
            Ticket::create($ticketData);
        }

        $this->command->info('Created ' . count($tickets) . ' support tickets with realistic business scenarios.');
    }
}
