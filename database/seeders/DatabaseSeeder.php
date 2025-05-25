<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class, // Add role-permission associations
            DepartmentSeeder::class,
            AdminUserSeeder::class,
            CustomerSeeder::class,
            ServerGroupSeeder::class, // Add server groups before products
            ProductSeeder::class,
            ProductFeatureSeeder::class,
            OrderSeeder::class, // Add orders before invoices
            InvoiceSeeder::class,
            PaymentSeeder::class, // Add payments after invoices
            SubscriptionSeeder::class, // Add subscriptions after orders
            TicketSeeder::class, // Add support tickets
        ]);
    }
}
