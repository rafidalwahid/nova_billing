<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'System Dashboard' => [
                'Access System Dashboard' => 'View main dashboard with system overview, metrics, and key performance indicators',
            ],
            'Customer Management' => [
                'View Customer Accounts' => 'Browse and search customer account information, contact details, and account status',
                'Create Customer Accounts' => 'Register new customer accounts with complete profile and billing information',
                'Modify Customer Accounts' => 'Update customer information, contact details, billing addresses, and account settings',
                'Deactivate Customer Accounts' => 'Suspend or permanently deactivate customer accounts and associated services',
                'Suspend Customer Services' => 'Temporarily suspend customer services for non-payment or policy violations',
                'Reactivate Customer Services' => 'Restore suspended customer services and reactivate account access',
            ],
            'Order Processing' => [
                'View Customer Orders' => 'Access order history, order details, and track order status across all customers',
                'Create New Orders' => 'Generate new service orders for existing customers with product selection',
                'Process Pending Orders' => 'Review, approve, and fulfill customer orders through the order workflow',
                'Cancel Customer Orders' => 'Cancel pending or active orders and process associated refunds if applicable',
            ],
            'Invoice Management' => [
                'View Invoice Records' => 'Access invoice history, payment status, and detailed billing information',
                'Generate Customer Invoices' => 'Create new invoices for services, products, and custom billing items',
                'Modify Invoice Details' => 'Edit invoice line items, amounts, due dates, and billing information',
                'Delete Invoice Records' => 'Remove incorrect or duplicate invoices from the billing system',
                'Record Invoice Payments' => 'Mark invoices as paid and record payment details and transaction information',
                'Process Customer Refunds' => 'Issue refunds for overpayments, cancellations, and billing adjustments',
            ],
            'Product Catalog' => [
                'View Product Listings' => 'Browse product catalog, pricing information, and service specifications',
                'Add New Products' => 'Create new products and services with pricing, descriptions, and billing cycles',
                'Update Product Information' => 'Modify product details, pricing, availability, and service specifications',
                'Remove Products' => 'Deactivate or delete products from the catalog and billing system',
            ],
            'Infrastructure Management' => [
                'View Server Information' => 'Access server details, status monitoring, and infrastructure overview',
                'Configure New Servers' => 'Add new servers to the infrastructure with configuration and monitoring setup',
                'Modify Server Settings' => 'Update server configurations, monitoring parameters, and service assignments',
                'Remove Server Resources' => 'Decommission servers and remove them from active infrastructure',
                'Test Server Connectivity' => 'Perform connectivity tests and health checks on server infrastructure',
            ],
            'Support Ticket System' => [
                'View Support Tickets' => 'Access customer support tickets, issue tracking, and communication history',
                'Respond to Customer Tickets' => 'Reply to customer inquiries and provide support through the ticket system',
                'Resolve Support Tickets' => 'Close resolved tickets and update ticket status with resolution details',
                'Delete Ticket Records' => 'Remove spam, duplicate, or inappropriate tickets from the support system',
            ],
            'Staff Administration' => [
                'View Staff Directory' => 'Access employee information, roles, departments, and contact details',
                'Add New Staff Members' => 'Create new employee accounts with role assignments and access permissions',
                'Update Staff Information' => 'Modify employee details, role assignments, and department associations',
                'Remove Staff Access' => 'Deactivate employee accounts and revoke system access permissions',
            ],
            'Role Management' => [
                'View System Roles' => 'Browse role definitions, permission assignments, and access control settings',
                'Create Custom Roles' => 'Define new roles with specific permission sets and access levels',
                'Modify Role Permissions' => 'Update role definitions and adjust permission assignments for existing roles',
                'Delete System Roles' => 'Remove custom roles and reassign affected users to alternative roles',
            ],
        ];

        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $permissionName => $permissionDescription) {
                Permission::create([
                    'name' => $permissionName,
                    'slug' => Str::slug($permissionName),
                    'description' => $permissionDescription,
                    'module' => $module,
                ]);
            }
        }
    }
}
