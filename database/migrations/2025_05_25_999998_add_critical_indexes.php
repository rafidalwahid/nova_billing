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
        // Add missing indexes for customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->index('status', 'customers_status_idx');
        });

        // Add missing indexes for invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('status', 'invoices_status_idx');
            $table->index(['status', 'due_date'], 'invoices_status_due_date_idx');
        });

        // Add missing indexes for payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->index('status', 'payments_status_idx');
            $table->index(['status', 'payment_date'], 'payments_status_date_idx');
        });

        // Add missing indexes for hosting_accounts table
        Schema::table('hosting_accounts', function (Blueprint $table) {
            $table->index('status', 'hosting_accounts_status_idx');
            $table->index(['server_id', 'status'], 'hosting_accounts_server_status_idx');
        });

        // Add missing indexes for domain_registrations table
        Schema::table('domain_registrations', function (Blueprint $table) {
            $table->index('status', 'domain_registrations_status_idx');
            $table->index(['status', 'expiration_date'], 'domain_registrations_status_exp_idx');
        });

        // Add missing indexes for tickets table
        Schema::table('tickets', function (Blueprint $table) {
            $table->index('priority', 'tickets_priority_idx');
            $table->index(['assigned_to', 'status'], 'tickets_assigned_status_idx');
            $table->index(['status', 'priority'], 'tickets_status_priority_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_status_idx');
        });

        // Remove indexes from invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('invoices_status_idx');
            $table->dropIndex('invoices_status_due_date_idx');
        });

        // Remove indexes from payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_status_idx');
            $table->dropIndex('payments_status_date_idx');
        });

        // Remove indexes from hosting_accounts table
        Schema::table('hosting_accounts', function (Blueprint $table) {
            $table->dropIndex('hosting_accounts_status_idx');
            $table->dropIndex('hosting_accounts_server_status_idx');
        });

        // Remove indexes from domain_registrations table
        Schema::table('domain_registrations', function (Blueprint $table) {
            $table->dropIndex('domain_registrations_status_idx');
            $table->dropIndex('domain_registrations_status_exp_idx');
        });

        // Remove indexes from tickets table
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex('tickets_priority_idx');
            $table->dropIndex('tickets_assigned_status_idx');
            $table->dropIndex('tickets_status_priority_idx');
        });
    }
};
