<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Customer;
use App\Models\AdminUser;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create basic test data
        Role::create([
            'name' => 'Administrator',
            'description' => 'Full system access',
            'is_system' => true,
        ]);

        Department::create([
            'name' => 'Support',
            'description' => 'Customer Support Department',
        ]);
    }

    /** @test */
    public function user_can_be_created_with_customer_relationship()
    {
        $customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'country' => 'US',
            'postal_code' => '12345',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'userable_type' => Customer::class,
            'userable_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $user->userable);
        $this->assertEquals($customer->id, $user->userable->id);
        $this->assertTrue($user->isCustomer());
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function user_can_be_created_with_admin_user_relationship()
    {
        $role = Role::first();
        $department = Department::first();

        $adminUser = AdminUser::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone' => '555-5678',
            'role_id' => $role->id,
            'department_id' => $department->id,
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'userable_type' => AdminUser::class,
            'userable_id' => $adminUser->id,
        ]);

        $this->assertInstanceOf(AdminUser::class, $user->userable);
        $this->assertEquals($adminUser->id, $user->userable->id);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isCustomer());
    }

    /** @test */
    public function user_name_attribute_returns_full_name_from_polymorphic_relationship()
    {
        $customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'country' => 'US',
            'postal_code' => '12345',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'Original Name',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'userable_type' => Customer::class,
            'userable_id' => $customer->id,
        ]);

        // The name attribute should return the full name from the polymorphic relationship
        $this->assertEquals('John Doe', $user->name);
    }

    /** @test */
    public function user_display_name_attribute_works_correctly()
    {
        $customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'country' => 'US',
            'postal_code' => '12345',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'Original Name',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'userable_type' => Customer::class,
            'userable_id' => $customer->id,
        ]);

        $this->assertEquals('John Doe', $user->display_name);
    }

    /** @test */
    public function user_avatar_url_returns_gravatar_by_default()
    {
        $customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'country' => 'US',
            'postal_code' => '12345',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'userable_type' => Customer::class,
            'userable_id' => $customer->id,
        ]);

        $expectedGravatar = 'https://www.gravatar.com/avatar/' . md5('john@example.com') . '?d=mp&s=40';
        $this->assertEquals($expectedGravatar, $user->avatar_url);
    }

    /** @test */
    public function user_without_polymorphic_relationship_falls_back_gracefully()
    {
        $user = User::create([
            'name' => 'Standalone User',
            'email' => 'standalone@example.com',
            'password' => Hash::make('password'),
            'userable_type' => null,
            'userable_id' => null,
        ]);

        $this->assertFalse($user->isCustomer());
        $this->assertFalse($user->isAdmin());
        $this->assertEquals('Standalone User', $user->name);
        $this->assertEquals('Standalone User', $user->display_name);
    }

    /** @test */
    public function password_is_properly_hashed()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'userable_type' => null,
            'userable_id' => null,
        ]);

        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertFalse(Hash::check('wrong-password', $user->password));
    }

    /** @test */
    public function email_is_unique()
    {
        User::create([
            'name' => 'First User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'name' => 'Second User',
            'email' => 'test@example.com', // Duplicate email
            'password' => Hash::make('password'),
        ]);
    }
}
