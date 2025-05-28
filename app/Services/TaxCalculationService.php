<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class TaxCalculationService
{
    /**
     * Tax rates by country/state
     */
    private const TAX_RATES = [
        'US' => [
            'default' => 0.0875, // 8.75% default US rate
            'states' => [
                'CA' => 0.0975, // California
                'NY' => 0.08,   // New York
                'TX' => 0.0825, // Texas
                'FL' => 0.06,   // Florida
                'WA' => 0.065,  // Washington
                'OR' => 0.0,    // Oregon (no sales tax)
                'NH' => 0.0,    // New Hampshire (no sales tax)
                'MT' => 0.0,    // Montana (no sales tax)
                'DE' => 0.0,    // Delaware (no sales tax)
                'AK' => 0.0,    // Alaska (no state sales tax)
            ]
        ],
        'CA' => [
            'default' => 0.13, // 13% HST/GST for Canada
            'provinces' => [
                'ON' => 0.13,   // Ontario HST
                'QC' => 0.14975, // Quebec GST+QST
                'BC' => 0.12,   // British Columbia GST+PST
                'AB' => 0.05,   // Alberta GST only
                'SK' => 0.11,   // Saskatchewan GST+PST
                'MB' => 0.12,   // Manitoba GST+PST
                'NS' => 0.15,   // Nova Scotia HST
                'NB' => 0.15,   // New Brunswick HST
                'NL' => 0.15,   // Newfoundland HST
                'PE' => 0.15,   // Prince Edward Island HST
                'NT' => 0.05,   // Northwest Territories GST only
                'NU' => 0.05,   // Nunavut GST only
                'YT' => 0.05,   // Yukon GST only
            ]
        ],
        'GB' => ['default' => 0.20], // 20% VAT
        'DE' => ['default' => 0.19], // 19% VAT
        'FR' => ['default' => 0.20], // 20% VAT
        'AU' => ['default' => 0.10], // 10% GST
        'NZ' => ['default' => 0.15], // 15% GST
    ];

    /**
     * Tax-exempt product categories
     */
    private const TAX_EXEMPT_CATEGORIES = [
        'domain_registration', // Domain registrations are often tax-exempt
        'ssl_certificate',     // SSL certificates may be tax-exempt in some jurisdictions
    ];

    /**
     * Calculate tax amount for a customer and product/service.
     */
    public function calculateTax(Customer $customer, float $amount, ?Product $product = null): array
    {
        try {
            // Check if product is tax-exempt
            if ($product && $this->isProductTaxExempt($product)) {
                return [
                    'tax_rate' => 0.0,
                    'tax_amount' => 0.0,
                    'tax_description' => 'Tax-exempt product',
                    'tax_jurisdiction' => null,
                ];
            }

            // Get tax rate based on customer location
            $taxRate = $this->getTaxRateForCustomer($customer);
            $taxAmount = $amount * $taxRate;

            // Get jurisdiction description
            $jurisdiction = $this->getTaxJurisdiction($customer);

            return [
                'tax_rate' => $taxRate,
                'tax_amount' => round($taxAmount, 2),
                'tax_description' => $this->getTaxDescription($customer, $taxRate),
                'tax_jurisdiction' => $jurisdiction,
            ];

        } catch (\Exception $e) {
            Log::error('Tax calculation failed', [
                'customer_id' => $customer->id,
                'amount' => $amount,
                'product_id' => $product?->id,
                'error' => $e->getMessage(),
            ]);

            // Fallback to default rate
            return [
                'tax_rate' => 0.10, // 10% fallback rate
                'tax_amount' => round($amount * 0.10, 2),
                'tax_description' => 'Standard Tax (fallback)',
                'tax_jurisdiction' => 'Default',
            ];
        }
    }

    /**
     * Get tax rate for a specific customer based on their location.
     */
    private function getTaxRateForCustomer(Customer $customer): float
    {
        $country = strtoupper($customer->country ?? 'US');
        $state = strtoupper($customer->state ?? '');

        // Check if we have tax rates for this country
        if (!isset(self::TAX_RATES[$country])) {
            return 0.0; // No tax for unknown countries
        }

        $countryRates = self::TAX_RATES[$country];

        // For US, check state-specific rates
        if ($country === 'US' && $state && isset($countryRates['states'][$state])) {
            return $countryRates['states'][$state];
        }

        // For Canada, check province-specific rates
        if ($country === 'CA' && $state && isset($countryRates['provinces'][$state])) {
            return $countryRates['provinces'][$state];
        }

        // Return default rate for country
        return $countryRates['default'] ?? 0.0;
    }

    /**
     * Check if a product is tax-exempt.
     */
    private function isProductTaxExempt(Product $product): bool
    {
        return in_array($product->category, self::TAX_EXEMPT_CATEGORIES);
    }

    /**
     * Get tax jurisdiction description.
     */
    private function getTaxJurisdiction(Customer $customer): string
    {
        $country = strtoupper($customer->country ?? 'US');
        $state = strtoupper($customer->state ?? '');

        if ($country === 'US' && $state) {
            return "United States - {$state}";
        }

        if ($country === 'CA' && $state) {
            return "Canada - {$state}";
        }

        $countryNames = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'DE' => 'Germany',
            'FR' => 'France',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
        ];

        return $countryNames[$country] ?? $country;
    }

    /**
     * Get tax description for display.
     */
    private function getTaxDescription(Customer $customer, float $taxRate): string
    {
        $country = strtoupper($customer->country ?? 'US');
        $percentage = round($taxRate * 100, 2);

        $taxTypes = [
            'US' => 'Sales Tax',
            'CA' => 'HST/GST',
            'GB' => 'VAT',
            'DE' => 'VAT',
            'FR' => 'VAT',
            'AU' => 'GST',
            'NZ' => 'GST',
        ];

        $taxType = $taxTypes[$country] ?? 'Tax';

        return "{$taxType} ({$percentage}%)";
    }

    /**
     * Calculate tax for multiple line items.
     */
    public function calculateTaxForItems(Customer $customer, array $items): array
    {
        $totalTaxAmount = 0.0;
        $taxBreakdown = [];

        foreach ($items as $item) {
            $amount = $item['amount'] ?? 0.0;
            $product = $item['product'] ?? null;

            $taxCalculation = $this->calculateTax($customer, $amount, $product);
            $totalTaxAmount += $taxCalculation['tax_amount'];

            $taxBreakdown[] = [
                'item' => $item,
                'tax_calculation' => $taxCalculation,
            ];
        }

        return [
            'total_tax_amount' => round($totalTaxAmount, 2),
            'tax_breakdown' => $taxBreakdown,
        ];
    }

    /**
     * Validate customer tax information.
     */
    public function validateCustomerTaxInfo(Customer $customer): array
    {
        $errors = [];

        if (empty($customer->country)) {
            $errors[] = 'Country is required for tax calculation';
        }

        // For US customers, state is required for accurate tax calculation
        if ($customer->country === 'US' && empty($customer->state)) {
            $errors[] = 'State is required for US customers';
        }

        // For Canadian customers, province is required
        if ($customer->country === 'CA' && empty($customer->state)) {
            $errors[] = 'Province is required for Canadian customers';
        }

        return $errors;
    }
}
