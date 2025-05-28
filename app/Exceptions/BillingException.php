<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillingException extends Exception
{
    protected $errorCode;
    protected $context;

    public function __construct(
        string $message = 'A billing error occurred',
        string $errorCode = 'BILLING_ERROR',
        array $context = [],
        int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->context = $context;
    }

    /**
     * Get the error code.
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Get the context data.
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => [
                    'message' => $this->getMessage(),
                    'code' => $this->getErrorCode(),
                    'context' => $this->getContext(),
                ],
            ], 422);
        }

        return response()->view('errors.billing', [
            'message' => $this->getMessage(),
            'code' => $this->getErrorCode(),
        ], 422);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        \Log::error('Billing Exception: ' . $this->getMessage(), [
            'error_code' => $this->getErrorCode(),
            'context' => $this->getContext(),
            'trace' => $this->getTraceAsString(),
        ]);
    }
}

class InvoiceGenerationException extends BillingException
{
    public function __construct(string $message = 'Failed to generate invoice', array $context = [])
    {
        parent::__construct($message, 'INVOICE_GENERATION_FAILED', $context);
    }
}

class PaymentProcessingException extends BillingException
{
    public function __construct(string $message = 'Payment processing failed', array $context = [])
    {
        parent::__construct($message, 'PAYMENT_PROCESSING_FAILED', $context);
    }
}

class TaxCalculationException extends BillingException
{
    public function __construct(string $message = 'Tax calculation failed', array $context = [])
    {
        parent::__construct($message, 'TAX_CALCULATION_FAILED', $context);
    }
}

class SubscriptionException extends BillingException
{
    public function __construct(string $message = 'Subscription operation failed', array $context = [])
    {
        parent::__construct($message, 'SUBSCRIPTION_FAILED', $context);
    }
}
