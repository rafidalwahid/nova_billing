<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPricing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products and pricing (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductPricing::truncate();
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create hosting packages
        $this->createHostingPackages();

        // Create domain registration packages
        $this->createDomainPackages();

        // Create addon services
        $this->createAddonServices();
    }

    /**
     * Create hosting packages with realistic pricing
     */
    private function createHostingPackages(): void
    {
        $hostingPackages = [
            [
                'name' => 'Starter Web Hosting',
                'description' => 'Perfect for personal websites and small blogs. Includes 10GB SSD storage, unlimited bandwidth, 1 website, free SSL certificate, and 24/7 support.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 4.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 12.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 47.99],
                ]
            ],
            [
                'name' => 'Professional Web Hosting',
                'description' => 'Ideal for growing businesses and professional websites. Includes 50GB SSD storage, unlimited bandwidth, 10 websites, free SSL, daily backups, and priority support.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 9.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 26.99],
                    'semi_annually' => ['setup' => 0.00, 'recurring' => 49.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 89.99],
                ]
            ],
            [
                'name' => 'Business Web Hosting',
                'description' => 'Advanced hosting for high-traffic websites and e-commerce. Includes 200GB SSD storage, unlimited bandwidth, unlimited websites, free SSL, daily backups, staging environment, and dedicated support.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 19.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 54.99],
                    'semi_annually' => ['setup' => 0.00, 'recurring' => 99.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 179.99],
                ]
            ],
            [
                'name' => 'Enterprise Web Hosting',
                'description' => 'Premium hosting solution for large enterprises. Includes 500GB SSD storage, unlimited bandwidth, unlimited websites, free SSL, hourly backups, staging environment, CDN, and white-glove support.',
                'pricing' => [
                    'monthly' => ['setup' => 49.99, 'recurring' => 39.99],
                    'quarterly' => ['setup' => 49.99, 'recurring' => 109.99],
                    'semi_annually' => ['setup' => 49.99, 'recurring' => 199.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 359.99],
                ]
            ],
            [
                'name' => 'VPS Starter',
                'description' => 'Virtual Private Server for developers and small applications. Includes 2 CPU cores, 4GB RAM, 80GB SSD storage, 2TB bandwidth, full root access, and managed updates.',
                'pricing' => [
                    'monthly' => ['setup' => 25.00, 'recurring' => 29.99],
                    'quarterly' => ['setup' => 25.00, 'recurring' => 79.99],
                    'semi_annually' => ['setup' => 0.00, 'recurring' => 149.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 279.99],
                ]
            ],
            [
                'name' => 'VPS Professional',
                'description' => 'High-performance VPS for growing applications. Includes 4 CPU cores, 8GB RAM, 160GB SSD storage, 4TB bandwidth, full root access, managed updates, and priority support.',
                'pricing' => [
                    'monthly' => ['setup' => 25.00, 'recurring' => 59.99],
                    'quarterly' => ['setup' => 25.00, 'recurring' => 164.99],
                    'semi_annually' => ['setup' => 0.00, 'recurring' => 299.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 559.99],
                ]
            ],
            [
                'name' => 'Dedicated Server - Intel Xeon',
                'description' => 'Powerful dedicated server for mission-critical applications. Includes Intel Xeon E-2236 processor, 32GB DDR4 RAM, 1TB NVMe SSD, 10TB bandwidth, full server management, and 24/7 monitoring.',
                'pricing' => [
                    'monthly' => ['setup' => 99.99, 'recurring' => 199.99],
                    'quarterly' => ['setup' => 99.99, 'recurring' => 549.99],
                    'semi_annually' => ['setup' => 49.99, 'recurring' => 1049.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 1999.99],
                ]
            ],
        ];

        foreach ($hostingPackages as $packageData) {
            $product = Product::create([
                'name' => $packageData['name'],
                'type' => 'hosting',
                'description' => $packageData['description'],
                'is_active' => true,
            ]);

            foreach ($packageData['pricing'] as $cycle => $pricing) {
                ProductPricing::create([
                    'product_id' => $product->id,
                    'billing_cycle' => $cycle,
                    'setup_fee' => $pricing['setup'],
                    'recurring_fee' => $pricing['recurring'],
                ]);
            }
        }
    }

    /**
     * Create domain registration packages
     */
    private function createDomainPackages(): void
    {
        $domainPackages = [
            [
                'name' => '.com Domain Registration',
                'description' => 'Register your .com domain name with free WHOIS privacy protection, DNS management, and email forwarding. Most popular choice for businesses and personal websites.',
                'pricing' => [
                    'annually' => ['setup' => 0.00, 'recurring' => 12.99],
                ]
            ],
            [
                'name' => '.net Domain Registration',
                'description' => 'Professional .net domain registration ideal for technology companies and network services. Includes free WHOIS privacy, DNS management, and email forwarding.',
                'pricing' => [
                    'annually' => ['setup' => 0.00, 'recurring' => 14.99],
                ]
            ],
            [
                'name' => '.org Domain Registration',
                'description' => 'Perfect for non-profit organizations, communities, and open-source projects. Includes free WHOIS privacy protection and DNS management tools.',
                'pricing' => [
                    'annually' => ['setup' => 0.00, 'recurring' => 13.99],
                ]
            ],
            [
                'name' => '.info Domain Registration',
                'description' => 'Ideal for informational websites, blogs, and knowledge bases. Includes WHOIS privacy protection and comprehensive DNS management.',
                'pricing' => [
                    'annually' => ['setup' => 0.00, 'recurring' => 15.99],
                ]
            ],
            [
                'name' => '.biz Domain Registration',
                'description' => 'Professional domain extension for business websites and e-commerce stores. Includes free WHOIS privacy and business-grade DNS management.',
                'pricing' => [
                    'annually' => ['setup' => 0.00, 'recurring' => 16.99],
                ]
            ],
            [
                'name' => 'Premium .com Domain Transfer',
                'description' => 'Transfer your existing .com domain to our platform with enhanced security, premium DNS management, and priority support. Includes 1-year extension.',
                'pricing' => [
                    'annually' => ['setup' => 5.00, 'recurring' => 12.99],
                ]
            ],
        ];

        foreach ($domainPackages as $packageData) {
            $product = Product::create([
                'name' => $packageData['name'],
                'type' => 'domain',
                'description' => $packageData['description'],
                'is_active' => true,
            ]);

            foreach ($packageData['pricing'] as $cycle => $pricing) {
                ProductPricing::create([
                    'product_id' => $product->id,
                    'billing_cycle' => $cycle,
                    'setup_fee' => $pricing['setup'],
                    'recurring_fee' => $pricing['recurring'],
                ]);
            }
        }
    }

    /**
     * Create addon services
     */
    private function createAddonServices(): void
    {
        $addonServices = [
            [
                'name' => 'SSL Certificate - Standard',
                'description' => 'Domain Validated (DV) SSL certificate to secure your website with 256-bit encryption. Perfect for blogs, personal websites, and small business sites.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 8.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 79.99],
                ]
            ],
            [
                'name' => 'SSL Certificate - Wildcard',
                'description' => 'Wildcard SSL certificate to secure unlimited subdomains with enterprise-grade encryption. Ideal for large websites and applications.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 24.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 249.99],
                ]
            ],
            [
                'name' => 'Website Backup Pro',
                'description' => 'Automated daily backups with 30-day retention, one-click restore, and offsite storage. Includes malware scanning and cleanup service.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 4.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 12.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 47.99],
                ]
            ],
            [
                'name' => 'CDN Service - Global',
                'description' => 'Content Delivery Network with 200+ global edge locations to accelerate your website performance. Includes DDoS protection and real-time analytics.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 9.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 26.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 99.99],
                ]
            ],
            [
                'name' => 'Email Hosting Professional',
                'description' => 'Professional email hosting with 50GB storage per mailbox, spam filtering, mobile sync, and 99.9% uptime guarantee. Supports unlimited aliases.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 5.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 15.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 59.99],
                ]
            ],
            [
                'name' => 'Website Security Scanner',
                'description' => 'Advanced malware detection and removal service with real-time monitoring, vulnerability scanning, and automatic security updates.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 12.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 34.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 129.99],
                ]
            ],
            [
                'name' => 'Dedicated IP Address',
                'description' => 'Private dedicated IP address for your hosting account. Required for certain SSL certificates and email deliverability improvements.',
                'pricing' => [
                    'monthly' => ['setup' => 5.00, 'recurring' => 3.99],
                    'quarterly' => ['setup' => 5.00, 'recurring' => 10.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 39.99],
                ]
            ],
            [
                'name' => 'Priority Support Upgrade',
                'description' => 'Upgrade to priority support with guaranteed 1-hour response time, phone support, and dedicated account manager for technical assistance.',
                'pricing' => [
                    'monthly' => ['setup' => 0.00, 'recurring' => 19.99],
                    'quarterly' => ['setup' => 0.00, 'recurring' => 54.99],
                    'annually' => ['setup' => 0.00, 'recurring' => 199.99],
                ]
            ],
        ];

        foreach ($addonServices as $serviceData) {
            $product = Product::create([
                'name' => $serviceData['name'],
                'type' => 'addon',
                'description' => $serviceData['description'],
                'is_active' => true,
            ]);

            foreach ($serviceData['pricing'] as $cycle => $pricing) {
                ProductPricing::create([
                    'product_id' => $product->id,
                    'billing_cycle' => $cycle,
                    'setup_fee' => $pricing['setup'],
                    'recurring_fee' => $pricing['recurring'],
                ]);
            }
        }
    }
}
