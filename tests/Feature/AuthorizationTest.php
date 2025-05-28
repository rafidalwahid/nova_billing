<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\AdminUser;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $customer;
    protected $adminUser;
    protected $adminUserWithoutPermissions;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->createTestData();
    }

    /** @test */
    public function customer_can_only_view_their_own_tickets()
    {
        $customerTicket = $this->createTicketForCustomer($this->customer);
        $otherCustomer = $this->createCustomerWithUser();
        $otherTicket = $this->createTicketForCustomer($otherCustomer);

        $this->actingAs($this->customer->user);

        // Can view own ticket
        $this->assertTrue($this->customer->user->can('view', $customerTicket));
        
        // Cannot view other customer's ticket
        $this->assertFalse($this->customer->user->can('view', $otherTicket));
    }

    /** @test */
    public function customer_can_create_tickets()
    {
        $this->actingAs($this->customer->user);
        
        $this->assertTrue($this->customer->user->can('create', Ticket::class));
    }

    /** @test */
    public function customer_cannot_update_or_delete_tickets()
    {
        $ticket = $this->createTicketForCustomer($this->customer);
        
        $this->actingAs($this->customer->user);
        
        $this->assertFalse($this->customer->user->can('update', $ticket));
        $this->assertFalse($this->customer->user->can('delete', $ticket));
    }

    /** @test */
    public function customer_can_only_view_their_own_invoices()
    {
        $customerInvoice = $this->createInvoiceForCustomer($this->customer);
        $otherCustomer = $this->createCustomerWithUser();
        $otherInvoice = $this->createInvoiceForCustomer($otherCustomer);

        $this->actingAs($this->customer->user);

        // Can view own invoice
        $this->assertTrue($this->customer->user->can('view', $customerInvoice));
        
        // Cannot view other customer's invoice
        $this->assertFalse($this->customer->user->can('view', $otherInvoice));
    }

    /** @test */
    public function customer_cannot_access_admin_resources()
    {
        $this->actingAs($this->customer->user);
        
        // Customer should not be able to view any admin users
        $this->assertFalse($this->customer->user->can('viewAny', AdminUser::class));
        
        // Customer should not be able to view any roles
        $this->assertFalse($this->customer->user->can('viewAny', Role::class));
    }

    /** @test */
    public function admin_user_with_permissions_can_access_resources()
    {
        $this->actingAs($this->adminUser->user);
        
        // Admin with permissions should be able to view tickets
        $this->assertTrue($this->adminUser->user->can('viewAny', Ticket::class));
        
        // Admin with permissions should be able to view customers
        $this->assertTrue($this->adminUser->user->can('viewAny', Customer::class));
    }

    /** @test */
    public function admin_user_without_permissions_cannot_access_resources()
    {
        $this->actingAs($this->adminUserWithoutPermissions->user);
        
        // Admin without permissions should not be able to view tickets
        $this->assertFalse($this->adminUserWithoutPermissions->user->can('viewAny', Ticket::class));
    }

    /** @test */
    public function customer_can_view_customer_resources_but_filtered_to_own_data()
    {
        $this->actingAs($this->customer->user);
        
        // Customer should be able to view customer resources (but will be filtered)
        $this->assertTrue($this->customer->user->can('viewAny', Customer::class));
        
        // But can only view their own customer record
        $this->assertTrue($this->customer->user->can('view', $this->customer));
        
        $otherCustomer = $this->createCustomerWithUser();
        $this->assertFalse($this->customer->user->can('view', $otherCustomer));
    }

    protected function createTestData()
    {
        // Create permissions
        $supportViewPermission = Permission::create([
            'name' => 'View Support Tickets',
            'slug' => 'support_management.view',
            'description' => 'Can view support tickets',
            'module' => 'support',
        ]);

        $customerViewPermission = Permission::create([
            'name' => 'View Customer Accounts',
            'slug' => 'view-customer-accounts',
            'description' => 'Can view customer accounts',
            'module' => 'customers',
        ]);

        // Create roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'description' => 'Full system access',
            'is_system' => true,
        ]);

        $limitedRole = Role::create([
            'name' => 'Limited User',
            'description' => 'Limited access',
            'is_system' => false,
        ]);

        // Attach permissions to admin role
        $adminRole->permissions()->attach([$supportViewPermission->id, $customerViewPermission->id]);

        // Create department
        $department = Department::create([
            'name' => 'Support',
            'description' => 'Customer Support Department',
        ]);

        // Create test users
        $this->customer = $this->createCustomerWithUser();
        $this->adminUser = $this->createAdminUserWithUser(['role_id' => $adminRole->id]);
        $this->adminUserWithoutPermissions = $this->createAdminUserWithUser(['role_id' => $limitedRole->id]);
    }

    protected function createCustomerWithUser(array $customerAttributes = [])
    {
        $customer = Customer::create(array_merge([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'country' => 'US',
            'postal_code' => $this->faker->postcode,
            'status' => true,
        ], $customerAttributes));

        $user = User::create([
            'name' => $customer->first_name . ' ' . $customer->last_name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'userable_type' => Customer::class,
            'userable_id' => $customer->id,
        ]);

        return $customer->load('user');
    }

    protected function createAdminUserWithUser(array $adminAttributes = [])
    {
        $department = Department::first();

        $adminUser = AdminUser::create(array_merge([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'department_id' => $department->id,
            'status' => true,
        ], $adminAttributes));

        $user = User::create([
            'name' => $adminUser->first_name . ' ' . $adminUser->last_name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'userable_type' => AdminUser::class,
            'userable_id' => $adminUser->id,
        ]);

        return $adminUser->load('user');
    }

    protected function createTicketForCustomer(Customer $customer)
    {
        return Ticket::create([
            'customer_id' => $customer->id,
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'open',
            'priority' => 'medium',
            'category' => 'general',
            'source' => 'customer_portal',
        ]);
    }

    protected function createInvoiceForCustomer(Customer $customer)
    {
        return Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            'status' => 'sent',
            'subtotal' => 100.00,
            'tax_amount' => 8.75,
            'total' => 108.75,
            'balance_due' => 108.75,
            'currency' => 'USD',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
        ]);
    }
}
