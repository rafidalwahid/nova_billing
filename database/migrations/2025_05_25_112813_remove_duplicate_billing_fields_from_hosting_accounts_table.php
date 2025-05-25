<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hosting_accounts', function (Blueprint $table) {
            // Remove duplicate billing fields - these should come from subscription
            $table->dropColumn([
                'setup_fee',
                'monthly_fee',
                'billing_cycle',
                'next_due_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hosting_accounts', function (Blueprint $table) {
            // Restore the billing fields if migration is rolled back
            $table->decimal('setup_fee', 10, 2)->default(0);
            $table->decimal('monthly_fee', 10, 2)->default(0);
            $table->string('billing_cycle', 50)->default('monthly');
            $table->date('next_due_date')->nullable();
        });
    }
};
