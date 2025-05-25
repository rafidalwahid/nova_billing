<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ServerGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackageManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test server group creation and assignment to products.
     */
    public function test_server_group_creation_and_product_assignment(): void
    {
        // Create a server group
        $serverGroup = ServerGroup::create([
            'name' => 'Test Hosting Group',
            'description' => 'Test server group for hosting packages',
            'fill_method' => 'round_robin',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('server_groups', [
            'name' => 'Test Hosting Group',
            'fill_method' => 'round_robin',
            'is_active' => true,
        ]);

        // Create a hosting product and assign it to the server group
        $product = Product::create([
            'name' => 'Test Hosting Package',
            'type' => 'hosting',
            'description' => 'Test hosting package',
            'is_active' => true,
            'server_group_id' => $serverGroup->id,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Hosting Package',
            'type' => 'hosting',
            'server_group_id' => $serverGroup->id,
        ]);

        // Test the relationship
        $this->assertEquals($serverGroup->id, $product->serverGroup->id);
        $this->assertEquals($product->id, $serverGroup->products->first()->id);
    }

    /**
     * Test that non-hosting products don't require server groups.
     */
    public function test_non_hosting_products_without_server_groups(): void
    {
        // Create domain and addon products without server groups
        $domainProduct = Product::create([
            'name' => 'Test Domain',
            'type' => 'domain',
            'description' => 'Test domain registration',
            'is_active' => true,
        ]);

        $addonProduct = Product::create([
            'name' => 'Test Addon',
            'type' => 'addon',
            'description' => 'Test addon service',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Domain',
            'type' => 'domain',
            'server_group_id' => null,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Addon',
            'type' => 'addon',
            'server_group_id' => null,
        ]);

        $this->assertNull($domainProduct->server_group_id);
        $this->assertNull($addonProduct->server_group_id);
    }

    /**
     * Test server group fill method display.
     */
    public function test_server_group_fill_method_display(): void
    {
        $serverGroup = ServerGroup::create([
            'name' => 'Test Group',
            'description' => 'Test description',
            'fill_method' => 'least_used',
            'is_active' => true,
        ]);

        $this->assertEquals('Least Used', $serverGroup->fill_method_display);
    }
}
