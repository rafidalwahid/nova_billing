<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing features
        ProductFeature::truncate();

        // Add features for hosting products
        $this->addHostingFeatures();

        // Add features for domain products
        $this->addDomainFeatures();

        // Add features for addon products
        $this->addAddonFeatures();
    }

    /**
     * Add features for hosting products
     */
    private function addHostingFeatures(): void
    {
        $hostingProducts = [
            'Starter Web Hosting' => [
                ['storage', 'disk_space', '10', 'Disk Space', 1, true],
                ['bandwidth', 'monthly_bandwidth', 'unlimited', 'Monthly Bandwidth', 2, true],
                ['domains', 'websites_included', '1', 'Websites', 3, true],
                ['email', 'email_accounts', '5', 'Email Accounts', 4, false],
                ['ssl', 'free_ssl', 'yes', 'Free SSL Certificate', 5, true],
                ['database', 'mysql_databases', '1', 'MySQL Databases', 6, false],
                ['support', 'support_level', '24/7 Basic', 'Support Level', 7, false],
                ['backup', 'backup_frequency', 'Weekly', 'Backup Frequency', 8, false],
            ],
            'Professional Web Hosting' => [
                ['storage', 'disk_space', '50', 'Disk Space', 1, true],
                ['bandwidth', 'monthly_bandwidth', 'unlimited', 'Monthly Bandwidth', 2, true],
                ['domains', 'websites_included', '10', 'Websites', 3, true],
                ['email', 'email_accounts', '25', 'Email Accounts', 4, false],
                ['ssl', 'free_ssl', 'yes', 'Free SSL Certificate', 5, true],
                ['database', 'mysql_databases', '10', 'MySQL Databases', 6, false],
                ['support', 'support_level', '24/7 Priority', 'Support Level', 7, false],
                ['backup', 'backup_frequency', 'Daily', 'Backup Frequency', 8, true],
                ['performance', 'ssd_storage', 'yes', 'SSD Storage', 9, false],
            ],
            'Business Web Hosting' => [
                ['storage', 'disk_space', '200', 'Disk Space', 1, true],
                ['bandwidth', 'monthly_bandwidth', 'unlimited', 'Monthly Bandwidth', 2, true],
                ['domains', 'websites_included', 'unlimited', 'Websites', 3, true],
                ['email', 'email_accounts', 'unlimited', 'Email Accounts', 4, false],
                ['ssl', 'free_ssl', 'yes', 'Free SSL Certificate', 5, true],
                ['database', 'mysql_databases', 'unlimited', 'MySQL Databases', 6, false],
                ['support', 'support_level', '24/7 Dedicated', 'Support Level', 7, false],
                ['backup', 'backup_frequency', 'Daily', 'Backup Frequency', 8, true],
                ['performance', 'ssd_storage', 'yes', 'SSD Storage', 9, false],
                ['other', 'staging_environment', 'yes', 'Staging Environment', 10, true],
            ],
            'Enterprise Web Hosting' => [
                ['storage', 'disk_space', '500', 'Disk Space', 1, true],
                ['bandwidth', 'monthly_bandwidth', 'unlimited', 'Monthly Bandwidth', 2, true],
                ['domains', 'websites_included', 'unlimited', 'Websites', 3, true],
                ['email', 'email_accounts', 'unlimited', 'Email Accounts', 4, false],
                ['ssl', 'free_ssl', 'yes', 'Free SSL Certificate', 5, true],
                ['database', 'mysql_databases', 'unlimited', 'MySQL Databases', 6, false],
                ['support', 'support_level', 'White-glove', 'Support Level', 7, true],
                ['backup', 'backup_frequency', 'Hourly', 'Backup Frequency', 8, true],
                ['performance', 'ssd_storage', 'yes', 'SSD Storage', 9, false],
                ['performance', 'cdn_included', 'yes', 'CDN Included', 10, true],
                ['other', 'staging_environment', 'yes', 'Staging Environment', 11, false],
            ],
            'VPS Starter' => [
                ['performance', 'cpu_cores', '2', 'CPU Cores', 1, true],
                ['performance', 'ram_gb', '4', 'RAM', 2, true],
                ['storage', 'ssd_storage_gb', '80', 'SSD Storage', 3, true],
                ['bandwidth', 'monthly_bandwidth_tb', '2', 'Monthly Bandwidth', 4, true],
                ['other', 'root_access', 'yes', 'Full Root Access', 5, false],
                ['support', 'managed_updates', 'yes', 'Managed Updates', 6, false],
                ['support', 'support_level', '24/7 Technical', 'Support Level', 7, false],
            ],
            'VPS Professional' => [
                ['performance', 'cpu_cores', '4', 'CPU Cores', 1, true],
                ['performance', 'ram_gb', '8', 'RAM', 2, true],
                ['storage', 'ssd_storage_gb', '160', 'SSD Storage', 3, true],
                ['bandwidth', 'monthly_bandwidth_tb', '4', 'Monthly Bandwidth', 4, true],
                ['other', 'root_access', 'yes', 'Full Root Access', 5, false],
                ['support', 'managed_updates', 'yes', 'Managed Updates', 6, false],
                ['support', 'support_level', '24/7 Priority', 'Support Level', 7, true],
            ],
            'Dedicated Server - Intel Xeon' => [
                ['performance', 'processor', 'Intel Xeon E-2236', 'Processor', 1, true],
                ['performance', 'ram_gb', '32', 'DDR4 RAM', 2, true],
                ['storage', 'nvme_storage_tb', '1', 'NVMe SSD Storage', 3, true],
                ['bandwidth', 'monthly_bandwidth_tb', '10', 'Monthly Bandwidth', 4, true],
                ['support', 'server_management', 'Full Management', 'Server Management', 5, true],
                ['support', 'monitoring', '24/7 Monitoring', 'Monitoring', 6, false],
                ['support', 'support_level', 'Dedicated Manager', 'Support Level', 7, false],
            ],
        ];

        foreach ($hostingProducts as $productName => $features) {
            $product = Product::where('name', $productName)->first();
            if ($product) {
                foreach ($features as $index => $feature) {
                    ProductFeature::create([
                        'product_id' => $product->id,
                        'feature_type' => $feature[0],
                        'feature_key' => $feature[1],
                        'feature_value' => $feature[2],
                        'display_name' => $feature[3],
                        'display_order' => $feature[4],
                        'is_highlighted' => $feature[5],
                    ]);
                }
            }
        }
    }

    /**
     * Add features for domain products
     */
    private function addDomainFeatures(): void
    {
        $domainProducts = [
            '.com Domain Registration' => [
                ['domains', 'domain_extension', '.com', 'Domain Extension', 1, true],
                ['domains', 'registration_period', '1 year', 'Registration Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['other', 'dns_management', 'yes', 'DNS Management', 4, false],
                ['email', 'email_forwarding', 'yes', 'Email Forwarding', 5, false],
                ['support', 'support_level', '24/7 Basic', 'Support Level', 6, false],
            ],
            '.net Domain Registration' => [
                ['domains', 'domain_extension', '.net', 'Domain Extension', 1, true],
                ['domains', 'registration_period', '1 year', 'Registration Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['other', 'dns_management', 'yes', 'DNS Management', 4, false],
                ['email', 'email_forwarding', 'yes', 'Email Forwarding', 5, false],
                ['support', 'support_level', '24/7 Basic', 'Support Level', 6, false],
            ],
            '.org Domain Registration' => [
                ['domains', 'domain_extension', '.org', 'Domain Extension', 1, true],
                ['domains', 'registration_period', '1 year', 'Registration Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['other', 'dns_management', 'yes', 'DNS Management', 4, false],
                ['email', 'email_forwarding', 'yes', 'Email Forwarding', 5, false],
                ['support', 'support_level', '24/7 Basic', 'Support Level', 6, false],
            ],
            '.info Domain Registration' => [
                ['domains', 'domain_extension', '.info', 'Domain Extension', 1, true],
                ['domains', 'registration_period', '1 year', 'Registration Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['other', 'dns_management', 'yes', 'DNS Management', 4, false],
                ['email', 'email_forwarding', 'yes', 'Email Forwarding', 5, false],
                ['support', 'support_level', '24/7 Basic', 'Support Level', 6, false],
            ],
            '.biz Domain Registration' => [
                ['domains', 'domain_extension', '.biz', 'Domain Extension', 1, true],
                ['domains', 'registration_period', '1 year', 'Registration Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['other', 'dns_management', 'Business-grade', 'DNS Management', 4, true],
                ['email', 'email_forwarding', 'yes', 'Email Forwarding', 5, false],
                ['support', 'support_level', '24/7 Business', 'Support Level', 6, false],
            ],
            'Premium .com Domain Transfer' => [
                ['domains', 'domain_extension', '.com', 'Domain Extension', 1, true],
                ['domains', 'transfer_period', '1 year extension', 'Transfer Period', 2, true],
                ['security', 'whois_privacy', 'yes', 'WHOIS Privacy Protection', 3, true],
                ['security', 'enhanced_security', 'yes', 'Enhanced Security', 4, true],
                ['other', 'dns_management', 'Premium', 'Premium DNS Management', 5, true],
                ['support', 'support_level', '24/7 Priority', 'Support Level', 6, false],
            ],
        ];

        foreach ($domainProducts as $productName => $features) {
            $product = Product::where('name', $productName)->first();
            if ($product) {
                foreach ($features as $index => $feature) {
                    ProductFeature::create([
                        'product_id' => $product->id,
                        'feature_type' => $feature[0],
                        'feature_key' => $feature[1],
                        'feature_value' => $feature[2],
                        'display_name' => $feature[3],
                        'display_order' => $feature[4],
                        'is_highlighted' => $feature[5],
                    ]);
                }
            }
        }
    }

    /**
     * Add features for addon products
     */
    private function addAddonFeatures(): void
    {
        $addonProducts = [
            'SSL Certificate - Standard' => [
                ['ssl', 'certificate_type', 'Domain Validated (DV)', 'Certificate Type', 1, true],
                ['ssl', 'encryption_level', '256-bit', 'Encryption Level', 2, true],
                ['ssl', 'warranty', '$10,000', 'Warranty Coverage', 3, false],
                ['ssl', 'browser_compatibility', '99.9%', 'Browser Compatibility', 4, false],
                ['support', 'installation_support', 'yes', 'Installation Support', 5, false],
            ],
            'SSL Certificate - Wildcard' => [
                ['ssl', 'certificate_type', 'Wildcard', 'Certificate Type', 1, true],
                ['ssl', 'subdomain_coverage', 'unlimited', 'Subdomain Coverage', 2, true],
                ['ssl', 'encryption_level', '256-bit', 'Encryption Level', 3, true],
                ['ssl', 'warranty', '$100,000', 'Warranty Coverage', 4, false],
                ['ssl', 'browser_compatibility', '99.9%', 'Browser Compatibility', 5, false],
                ['support', 'installation_support', 'yes', 'Installation Support', 6, false],
            ],
            'Website Backup Pro' => [
                ['backup', 'backup_frequency', 'Daily', 'Backup Frequency', 1, true],
                ['backup', 'retention_period', '30 days', 'Retention Period', 2, true],
                ['backup', 'storage_location', 'Offsite', 'Storage Location', 3, true],
                ['backup', 'restore_method', 'One-click', 'Restore Method', 4, false],
                ['security', 'malware_scanning', 'yes', 'Malware Scanning', 5, false],
                ['security', 'cleanup_service', 'yes', 'Cleanup Service', 6, false],
            ],
            'CDN Service - Global' => [
                ['performance', 'edge_locations', '200+', 'Edge Locations', 1, true],
                ['performance', 'global_coverage', 'yes', 'Global Coverage', 2, true],
                ['security', 'ddos_protection', 'yes', 'DDoS Protection', 3, true],
                ['other', 'real_time_analytics', 'yes', 'Real-time Analytics', 4, false],
                ['performance', 'cache_optimization', 'yes', 'Cache Optimization', 5, false],
                ['support', 'support_level', '24/7 Technical', 'Support Level', 6, false],
            ],
            'Email Hosting Professional' => [
                ['email', 'storage_per_mailbox', '50', 'Storage per Mailbox', 1, true],
                ['email', 'spam_filtering', 'yes', 'Spam Filtering', 2, true],
                ['email', 'mobile_sync', 'yes', 'Mobile Sync', 3, true],
                ['email', 'uptime_guarantee', '99.9%', 'Uptime Guarantee', 4, false],
                ['email', 'aliases_supported', 'unlimited', 'Email Aliases', 5, false],
                ['support', 'support_level', '24/7 Email', 'Support Level', 6, false],
            ],
            'Website Security Scanner' => [
                ['security', 'malware_detection', 'Real-time', 'Malware Detection', 1, true],
                ['security', 'vulnerability_scanning', 'yes', 'Vulnerability Scanning', 2, true],
                ['security', 'automatic_removal', 'yes', 'Automatic Removal', 3, true],
                ['security', 'monitoring_frequency', '24/7', 'Monitoring Frequency', 4, false],
                ['security', 'security_updates', 'Automatic', 'Security Updates', 5, false],
                ['support', 'support_level', '24/7 Security', 'Support Level', 6, false],
            ],
            'Dedicated IP Address' => [
                ['other', 'ip_type', 'IPv4 Dedicated', 'IP Type', 1, true],
                ['ssl', 'ssl_compatibility', 'yes', 'SSL Compatibility', 2, true],
                ['email', 'email_deliverability', 'Improved', 'Email Deliverability', 3, true],
                ['other', 'geographic_location', 'US/EU', 'Geographic Location', 4, false],
                ['support', 'setup_assistance', 'yes', 'Setup Assistance', 5, false],
            ],
            'Priority Support Upgrade' => [
                ['support', 'response_time', '1 hour', 'Response Time', 1, true],
                ['support', 'phone_support', 'yes', 'Phone Support', 2, true],
                ['support', 'dedicated_manager', 'yes', 'Dedicated Account Manager', 3, true],
                ['support', 'technical_assistance', 'Advanced', 'Technical Assistance', 4, false],
                ['support', 'availability', '24/7/365', 'Availability', 5, false],
            ],
        ];

        foreach ($addonProducts as $productName => $features) {
            $product = Product::where('name', $productName)->first();
            if ($product) {
                foreach ($features as $index => $feature) {
                    ProductFeature::create([
                        'product_id' => $product->id,
                        'feature_type' => $feature[0],
                        'feature_key' => $feature[1],
                        'feature_value' => $feature[2],
                        'display_name' => $feature[3],
                        'display_order' => $feature[4],
                        'is_highlighted' => $feature[5],
                    ]);
                }
            }
        }
    }
}
