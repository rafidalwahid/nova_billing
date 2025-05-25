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
            // Remove hardcoded limit fields - these should come from ProductFeature
            $table->dropColumn([
                'disk_limit_mb',
                'bandwidth_limit_mb',
                'email_limit',
                'database_limit',
                'subdomain_limit'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hosting_accounts', function (Blueprint $table) {
            // Restore the limit fields if migration is rolled back
            $table->decimal('disk_limit_mb', 12, 2)->nullable();
            $table->decimal('bandwidth_limit_mb', 15, 2)->nullable();
            $table->integer('email_limit')->nullable();
            $table->integer('database_limit')->nullable();
            $table->integer('subdomain_limit')->nullable();
        });
    }
};
