<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for billing operations.
    |
    */
    'default_currency' => env('BILLING_DEFAULT_CURRENCY', 'USD'),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | List of currencies supported by the billing system.
    |
    */
    'supported_currencies' => [
        'USD' => 'US Dollar',
        'CAD' => 'Canadian Dollar',
        'GBP' => 'British Pound',
        'EUR' => 'Euro',
        'AUD' => 'Australian Dollar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    |
    | Available payment methods and their configurations.
    |
    */
    'payment_methods' => [
        'credit_card' => [
            'enabled' => env('PAYMENT_CREDIT_CARD_ENABLED', true),
            'display_name' => 'Credit Card',
            'processing_fee_percentage' => env('PAYMENT_CREDIT_CARD_FEE', 2.9),
            'processing_fee_fixed' => env('PAYMENT_CREDIT_CARD_FIXED_FEE', 0.30),
        ],
        'bank_transfer' => [
            'enabled' => env('PAYMENT_BANK_TRANSFER_ENABLED', true),
            'display_name' => 'Bank Transfer',
            'processing_fee_percentage' => env('PAYMENT_BANK_TRANSFER_FEE', 0.0),
            'processing_fee_fixed' => env('PAYMENT_BANK_TRANSFER_FIXED_FEE', 0.0),
        ],
        'paypal' => [
            'enabled' => env('PAYMENT_PAYPAL_ENABLED', true),
            'display_name' => 'PayPal',
            'processing_fee_percentage' => env('PAYMENT_PAYPAL_FEE', 3.49),
            'processing_fee_fixed' => env('PAYMENT_PAYPAL_FIXED_FEE', 0.49),
        ],
        'stripe' => [
            'enabled' => env('PAYMENT_STRIPE_ENABLED', true),
            'display_name' => 'Stripe',
            'processing_fee_percentage' => env('PAYMENT_STRIPE_FEE', 2.9),
            'processing_fee_fixed' => env('PAYMENT_STRIPE_FIXED_FEE', 0.30),
        ],
        'check' => [
            'enabled' => env('PAYMENT_CHECK_ENABLED', false),
            'display_name' => 'Check',
            'processing_fee_percentage' => 0.0,
            'processing_fee_fixed' => 0.0,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for invoice generation and management.
    |
    */
    'invoice' => [
        'number_prefix' => env('INVOICE_NUMBER_PREFIX', 'INV-'),
        'number_length' => env('INVOICE_NUMBER_LENGTH', 6),
        'due_days' => env('INVOICE_DUE_DAYS', 30),
        'late_fee_percentage' => env('INVOICE_LATE_FEE_PERCENTAGE', 1.5),
        'late_fee_grace_days' => env('INVOICE_LATE_FEE_GRACE_DAYS', 7),
        'auto_generate' => env('INVOICE_AUTO_GENERATE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for subscription billing.
    |
    */
    'subscription' => [
        'billing_cycles' => [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'semi_annually' => 'Semi-Annually',
            'annually' => 'Annually',
            'biennially' => 'Biennially',
        ],
        'grace_period_days' => env('SUBSCRIPTION_GRACE_PERIOD_DAYS', 3),
        'suspension_days' => env('SUBSCRIPTION_SUSPENSION_DAYS', 7),
        'cancellation_days' => env('SUBSCRIPTION_CANCELLATION_DAYS', 30),
        'proration_enabled' => env('SUBSCRIPTION_PRORATION_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Settings
    |--------------------------------------------------------------------------
    |
    | Tax calculation configuration.
    |
    */
    'tax' => [
        'enabled' => env('TAX_CALCULATION_ENABLED', true),
        'fallback_rate' => env('TAX_FALLBACK_RATE', 0.10),
        'exempt_categories' => [
            'domain_registration',
            'ssl_certificate',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Limits and Thresholds
    |--------------------------------------------------------------------------
    |
    | Various limits and thresholds for billing operations.
    |
    */
    'limits' => [
        'max_payment_amount' => env('MAX_PAYMENT_AMOUNT', 999999.99),
        'min_payment_amount' => env('MIN_PAYMENT_AMOUNT', 0.01),
        'max_invoice_amount' => env('MAX_INVOICE_AMOUNT', 999999.99),
        'max_refund_days' => env('MAX_REFUND_DAYS', 30),
        'payment_retry_attempts' => env('PAYMENT_RETRY_ATTEMPTS', 3),
        'payment_retry_delay_hours' => env('PAYMENT_RETRY_DELAY_HOURS', 24),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Email notification configuration.
    |
    */
    'notifications' => [
        'invoice_generated' => env('NOTIFY_INVOICE_GENERATED', true),
        'payment_received' => env('NOTIFY_PAYMENT_RECEIVED', true),
        'payment_failed' => env('NOTIFY_PAYMENT_FAILED', true),
        'subscription_expiring' => env('NOTIFY_SUBSCRIPTION_EXPIRING', true),
        'subscription_expired' => env('NOTIFY_SUBSCRIPTION_EXPIRED', true),
        'invoice_overdue' => env('NOTIFY_INVOICE_OVERDUE', true),
        
        // Days before expiration to send notifications
        'expiration_warning_days' => [
            env('NOTIFY_EXPIRATION_WARNING_DAYS_1', 30),
            env('NOTIFY_EXPIRATION_WARNING_DAYS_2', 7),
            env('NOTIFY_EXPIRATION_WARNING_DAYS_3', 1),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Settings
    |--------------------------------------------------------------------------
    |
    | Audit trail configuration.
    |
    */
    'audit' => [
        'enabled' => env('AUDIT_ENABLED', true),
        'retention_days' => env('AUDIT_RETENTION_DAYS', 2555), // 7 years
        'log_all_changes' => env('AUDIT_LOG_ALL_CHANGES', true),
        'log_financial_only' => env('AUDIT_LOG_FINANCIAL_ONLY', false),
    ],
];
