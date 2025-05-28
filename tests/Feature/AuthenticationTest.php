<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\AdminUser;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create basic roles and departments for testing
        $this->createBasicTestData();
    }

    /** @test */
    public function customer_can_login_with_valid_credentials()
    {
        $customer = $this->createCustomerWithUser();
        
        $response = $this->post('/nova/login', [
            'email' => $customer->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/nova/dashboards/customer-dashboard');
        $this->assertAuthenticatedAs($customer->user);
    }

    /** @test */
    public function admin_user_can_login_with_valid_credentials()
    {
        $adminUser = $this->createAdminUserWithUser();
        
        $response = $this->post('/nova/login', [
            'email' => $adminUser->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/nova/dashboards/main');
        $this->assertAuthenticatedAs($adminUser->user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $customer = $this->createCustomerWithUser();
        
        $response = $this->post('/nova/login', [
            'email' => $customer->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function customer_user_is_correctly_identified()
    {
        $customer = $this->createCustomerWithUser();
        
        $this->assertTrue($customer->user->isCustomer());
        $this->assertFalse($customer->user->isAdmin());
        $this->assertEquals(Customer::class, $customer->user->userable_type);
    }

    /** @test */
    public function admin_user_is_correctly_identified()
    {
        $adminUser = $this->createAdminUserWithUser();
        
        $this->assertTrue($adminUser->user->isAdmin());
        $this->assertFalse($adminUser->user->isCustomer());
        $this->assertEquals(AdminUser::class, $adminUser->user->userable_type);
    }

    /** @test */
    public function user_name_attribute_returns_full_name_from_polymorphic_relationship()
    {
        $customer = $this->createCustomerWithUser();
        
        $expectedName = $customer->first_name . ' ' . $customer->last_name;
        $this->assertEquals($expectedName, $customer->user->name);
    }

    /** @test */
    public function inactive_customer_cannot_access_system()
    {
        $customer = $this->createCustomerWithUser(['status' => false]);
        
        $response = $this->actingAs($customer->user)
                        ->get('/nova');

        // Should be redirected or denied access
        $response->assertStatus(403);
    }

    /** @test */
    public function inactive_admin_user_cannot_access_system()
    {
        $adminUser = $this->createAdminUserWithUser(['status' => false]);
        
        $response = $this->actingAs($adminUser->user)
                        ->get('/nova');

        // Should be redirected or denied access
        $response->assertStatus(403);
    }

    protected function createBasicTestData()
    {
        // Create a basic role
        Role::create([
            'name' => 'Administrator',
            'description' => 'Full system access',
            'is_system' => true,
        ]);

        // Create a basic department
        Department::create([
            'name' => 'Support',
            'description' => 'Customer Support Department',
        ]);
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
        $role = Role::first();
        $department = Department::first();

        $adminUser = AdminUser::create(array_merge([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'role_id' => $role->id,
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
}
