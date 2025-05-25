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
        Schema::create('domain_registrations', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Domain information
            $table->string('domain_name')->unique();
            $table->string('tld', 10); // .com, .net, .org, etc.
            $table->string('registrar')->default('namecheap'); // namecheap, godaddy, etc.

            // Registration details
            $table->enum('status', ['pending', 'active', 'expired', 'suspended', 'cancelled', 'transferred'])->default('pending');
            $table->date('registration_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('registration_period')->default(1); // years

            // Registrar integration
            $table->string('registrar_domain_id')->nullable();
            $table->json('registrar_config')->nullable();
            $table->string('auth_code')->nullable(); // for transfers

            // DNS and nameservers
            $table->json('nameservers')->nullable(); // array of nameservers
            $table->boolean('dns_management')->default(false);
            $table->boolean('whois_privacy')->default(true);

            // Contact information (WHOIS)
            $table->json('registrant_contact')->nullable();
            $table->json('admin_contact')->nullable();
            $table->json('tech_contact')->nullable();
            $table->json('billing_contact')->nullable();

            // Auto-renewal and billing
            $table->boolean('auto_renew')->default(true);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('renewal_fee', 10, 2)->default(0);
            $table->date('next_due_date')->nullable();

            // Transfer information
            $table->boolean('transfer_lock')->default(true);
            $table->timestamp('transfer_requested_at')->nullable();
            $table->string('transfer_status')->nullable();

            // Additional services
            $table->boolean('email_forwarding')->default(false);
            $table->boolean('url_forwarding')->default(false);
            $table->json('additional_services')->nullable();

            // Metadata and notes
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'expiration_date']);
            $table->index(['registrar', 'status']);
            $table->index('tld');
            $table->index('expiration_date');
            $table->index('next_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_registrations');
    }
};
