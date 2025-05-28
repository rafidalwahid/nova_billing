<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class TaxCalculationService
{
    /**
     * Get tax rates from configuration.
     */
    private function getTaxRates(): array
    {
        return config('tax.rates', []);
    }

    /**
     * Get default tax rate from configuration.
     */
    private function getDefaultTaxRate(): float
    {
        return config('tax.default_rate', 0.0875);
    }

    /**
     * Get tax-exempt categories from configuration.
     */
    private function getTaxExemptCategories(): array
    {
        return config('tax.exempt_categories', []);
    }

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
        $taxRates = $this->getTaxRates();

        // Check if we have tax rates for this country
        if (!isset($taxRates[$country])) {
            return 0.0; // No tax for unknown countries
        }

        $countryRates = $taxRates[$country];

        // For US, check state-specific rates
        if ($country === 'US' && $state && isset($countryRates['states'][$state])) {
            return $countryRates['states'][$state];
        }

        // For Canada, check province-specific rates
        if ($country === 'CA' && $state && isset($countryRates['provinces'][$state])) {
            return $countryRates['provinces'][$state];
        }

        // Return default rate for country
        return $countryRates['default'] ?? $this->getDefaultTaxRate();
    }

    /**
     * Check if a product is tax-exempt.
     */
    private function isProductTaxExempt(Product $product): bool
    {
        $exemptCategories = $this->getTaxExemptCategories();
        return in_array($product->category, $exemptCategories);
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
