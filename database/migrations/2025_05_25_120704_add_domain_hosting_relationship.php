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
        // Add domain_registration_id to hosting_accounts table
        Schema::table('hosting_accounts', function (Blueprint $table) {
            $table->foreignId('domain_registration_id')
                  ->nullable()
                  ->after('order_id')
                  ->constrained('domain_registrations')
                  ->onDelete('set null');

            $table->index('domain_registration_id');
        });

        // Add hosting_account_id to domain_registrations table (optional reverse link)
        Schema::table('domain_registrations', function (Blueprint $table) {
            $table->foreignId('hosting_account_id')
                  ->nullable()
                  ->after('order_id')
                  ->constrained('hosting_accounts')
                  ->onDelete('set null');

            $table->index('hosting_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hosting_accounts', function (Blueprint $table) {
            $table->dropForeign(['domain_registration_id']);
            $table->dropColumn('domain_registration_id');
        });

        Schema::table('domain_registrations', function (Blueprint $table) {
            $table->dropForeign(['hosting_account_id']);
            $table->dropColumn('hosting_account_id');
        });
    }
};
