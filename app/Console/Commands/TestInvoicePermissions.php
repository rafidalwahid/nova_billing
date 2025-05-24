<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\Role;
use App\Models\Invoice;
use App\Models\Permission;

class TestInvoicePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:invoice-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test invoice management permissions for different user roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Invoice Management Permissions...');
        $this->newLine();

        // Get test users with different roles
        $roles = ['System Administrator', 'Billing Manager', 'Customer Support Representative', 'Financial Controller'];

        foreach ($roles as $roleName) {
            $this->testRolePermissions($roleName);
            $this->newLine();
        }

        $this->info('Permission testing completed!');
    }

    private function testRolePermissions(string $roleName): void
    {
        $this->info("Testing permissions for: {$roleName}");

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Role '{$roleName}' not found!");
            return;
        }

        $adminUser = $role->staff()->first();
        if (!$adminUser) {
            $this->warn("No admin user found for role '{$roleName}'");
            return;
        }

        $user = $adminUser->user;
        if (!$user) {
            $this->warn("No user account found for admin user in role '{$roleName}'");
            return;
        }

        // Test invoice permissions
        $invoice = Invoice::first();
        if (!$invoice) {
            $this->warn("No invoices found for testing");
            return;
        }

        $permissions = [
            'viewAny' => 'View Invoices',
            'view' => 'View Invoice Details',
            'create' => 'Create Invoices',
            'update' => 'Update Invoices',
            'delete' => 'Delete Invoices',
            'markAsPaid' => 'Mark as Paid',
            'recordPayment' => 'Record Payment',
            'sendEmail' => 'Send Email',
        ];

        foreach ($permissions as $method => $description) {
            $canPerform = false;

            try {
                if ($method === 'viewAny' || $method === 'create') {
                    $canPerform = $user->can($method, Invoice::class);
                } else {
                    $canPerform = $user->can($method, $invoice);
                }
            } catch (\Exception $e) {
                $this->error("Error testing {$method}: " . $e->getMessage());
                continue;
            }

            $status = $canPerform ? '<fg=green>✓</>' : '<fg=red>✗</>';
            $this->line("  {$status} {$description}");
        }

        // Show role permissions count
        $permissionCount = $role->permissions()->count();
        $this->line("  <fg=yellow>Total permissions: {$permissionCount}</>");
    }
}
