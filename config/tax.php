<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tax Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the tax configuration for the billing system.
    | Tax rates can be configured by country and state/province.
    |
    */

    'default_rate' => env('TAX_DEFAULT_RATE', 0.0875), // 8.75% default

    'rates' => [
        'US' => [
            'default' => env('TAX_US_DEFAULT_RATE', 0.0875), // 8.75% default US rate
            'states' => [
                'CA' => env('TAX_US_CA_RATE', 0.0975), // California
                'NY' => env('TAX_US_NY_RATE', 0.08),   // New York
                'TX' => env('TAX_US_TX_RATE', 0.0825), // Texas
                'FL' => env('TAX_US_FL_RATE', 0.06),   // Florida
                'WA' => env('TAX_US_WA_RATE', 0.065),  // Washington
                'OR' => env('TAX_US_OR_RATE', 0.0),    // Oregon (no sales tax)
                'NH' => env('TAX_US_NH_RATE', 0.0),    // New Hampshire (no sales tax)
                'MT' => env('TAX_US_MT_RATE', 0.0),    // Montana (no sales tax)
                'DE' => env('TAX_US_DE_RATE', 0.0),    // Delaware (no sales tax)
                'AK' => env('TAX_US_AK_RATE', 0.0),    // Alaska (no state sales tax)
            ]
        ],
        'CA' => [
            'default' => env('TAX_CA_DEFAULT_RATE', 0.13), // 13% default Canada rate (HST)
            'provinces' => [
                'ON' => env('TAX_CA_ON_RATE', 0.13),   // Ontario (HST)
                'QC' => env('TAX_CA_QC_RATE', 0.14975), // Quebec (GST + QST)
                'BC' => env('TAX_CA_BC_RATE', 0.12),   // British Columbia (HST)
                'AB' => env('TAX_CA_AB_RATE', 0.05),   // Alberta (GST only)
                'SK' => env('TAX_CA_SK_RATE', 0.11),   // Saskatchewan (HST)
                'MB' => env('TAX_CA_MB_RATE', 0.12),   // Manitoba (GST + PST)
                'NS' => env('TAX_CA_NS_RATE', 0.15),   // Nova Scotia (HST)
                'NB' => env('TAX_CA_NB_RATE', 0.15),   // New Brunswick (HST)
                'NL' => env('TAX_CA_NL_RATE', 0.15),   // Newfoundland and Labrador (HST)
                'PE' => env('TAX_CA_PE_RATE', 0.15),   // Prince Edward Island (HST)
                'NT' => env('TAX_CA_NT_RATE', 0.05),   // Northwest Territories (GST only)
                'NU' => env('TAX_CA_NU_RATE', 0.05),   // Nunavut (GST only)
                'YT' => env('TAX_CA_YT_RATE', 0.05),   // Yukon (GST only)
            ]
        ],
        'GB' => [
            'default' => env('TAX_GB_DEFAULT_RATE', 0.20), // 20% VAT
        ],
        'DE' => [
            'default' => env('TAX_DE_DEFAULT_RATE', 0.19), // 19% VAT
        ],
        'FR' => [
            'default' => env('TAX_FR_DEFAULT_RATE', 0.20), // 20% VAT
        ],
        'AU' => [
            'default' => env('TAX_AU_DEFAULT_RATE', 0.10), // 10% GST
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax-Exempt Product Categories
    |--------------------------------------------------------------------------
    |
    | Define which product categories or types are tax-exempt.
    |
    */

    'exempt_categories' => [
        'domain_registration',
        'ssl_certificate',
        // Add more exempt categories as needed
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Calculation Settings
    |--------------------------------------------------------------------------
    |
    | Configure how taxes are calculated and applied.
    |
    */

    'calculation' => [
        'round_precision' => 2,
        'round_mode' => PHP_ROUND_HALF_UP,
        'include_shipping' => env('TAX_INCLUDE_SHIPPING', true),
        'compound_taxes' => env('TAX_COMPOUND_TAXES', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Display Settings
    |--------------------------------------------------------------------------
    |
    | Configure how taxes are displayed to customers.
    |
    */

    'display' => [
        'show_tax_inclusive_prices' => env('TAX_SHOW_INCLUSIVE_PRICES', false),
        'tax_label' => env('TAX_LABEL', 'Tax'),
        'vat_label' => env('VAT_LABEL', 'VAT'),
        'gst_label' => env('GST_LABEL', 'GST'),
        'hst_label' => env('HST_LABEL', 'HST'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Reporting Settings
    |--------------------------------------------------------------------------
    |
    | Configure tax reporting and compliance features.
    |
    */

    'reporting' => [
        'enabled' => env('TAX_REPORTING_ENABLED', true),
        'frequency' => env('TAX_REPORTING_FREQUENCY', 'monthly'), // monthly, quarterly, annually
        'auto_generate_reports' => env('TAX_AUTO_GENERATE_REPORTS', false),
    ],

];
