<?php

namespace App\Console\Commands;

use App\Models\DomainRegistration;
use App\Models\HostingAccount;
use Illuminate\Console\Command;

class LinkDomainsToHostingAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:link-domains-hosting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link domain registrations to hosting accounts based on matching domain names';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Linking domains to hosting accounts...');

        $linked = 0;
        $skipped = 0;

        // Get all domain registrations without hosting account links
        $domains = DomainRegistration::whereNull('hosting_account_id')->get();

        foreach ($domains as $domain) {
            $fullDomain = $domain->domain_name . $domain->tld;

            // Find matching hosting account
            $hostingAccount = HostingAccount::where('domain', $fullDomain)->first();

            if ($hostingAccount) {
                // Link them together
                $domain->update(['hosting_account_id' => $hostingAccount->id]);
                $hostingAccount->update(['domain_registration_id' => $domain->id]);

                $this->line("✅ Linked {$fullDomain}: Domain #{$domain->id} ↔ Hosting #{$hostingAccount->id}");
                $linked++;
            } else {
                $this->line("⚠️  No hosting account found for domain: {$fullDomain}");
                $skipped++;
            }
        }

        // Also link hosting accounts without domain links
        $hostingAccounts = HostingAccount::whereNull('domain_registration_id')->get();

        foreach ($hostingAccounts as $hostingAccount) {
            $domain = DomainRegistration::where('domain_name', pathinfo($hostingAccount->domain, PATHINFO_FILENAME))
                ->where('tld', '.' . pathinfo($hostingAccount->domain, PATHINFO_EXTENSION))
                ->whereNull('hosting_account_id')
                ->first();

            if ($domain) {
                // Link them together
                $domain->update(['hosting_account_id' => $hostingAccount->id]);
                $hostingAccount->update(['domain_registration_id' => $domain->id]);

                $this->line("✅ Linked {$hostingAccount->domain}: Hosting #{$hostingAccount->id} ↔ Domain #{$domain->id}");
                $linked++;
            }
        }

        $this->info("🔗 Linked {$linked} domain-hosting pairs");
        if ($skipped > 0) {
            $this->warn("⚠️  Skipped {$skipped} domains without matching hosting accounts");
        }

        return 0;
    }
}
