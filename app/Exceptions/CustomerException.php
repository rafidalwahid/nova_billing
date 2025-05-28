<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerException extends Exception
{
    protected $errorCode;
    protected $context;

    public function __construct(
        string $message = 'A customer error occurred',
        string $errorCode = 'CUSTOMER_ERROR',
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

        return response()->view('errors.customer', [
            'message' => $this->getMessage(),
            'code' => $this->getErrorCode(),
        ], 422);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        \Log::warning('Customer Exception: ' . $this->getMessage(), [
            'error_code' => $this->getErrorCode(),
            'context' => $this->getContext(),
        ]);
    }
}

class CustomerNotFoundException extends CustomerException
{
    public function __construct(string $message = 'Customer not found', array $context = [])
    {
        parent::__construct($message, 'CUSTOMER_NOT_FOUND', $context, 404);
    }
}

class CustomerValidationException extends CustomerException
{
    public function __construct(string $message = 'Customer validation failed', array $context = [])
    {
        parent::__construct($message, 'CUSTOMER_VALIDATION_FAILED', $context, 422);
    }
}

class CustomerAccessDeniedException extends CustomerException
{
    public function __construct(string $message = 'Access denied', array $context = [])
    {
        parent::__construct($message, 'CUSTOMER_ACCESS_DENIED', $context, 403);
    }
}
