<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomerInvoiceController extends Controller
{
    /**
     * Get customer invoices with pagination and filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $invoices = $customer->invoices()
            ->with(['lines', 'payments', 'order'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $invoices->items(),
            'meta' => [
                'current_page' => $invoices->currentPage(),
                'last_page' => $invoices->lastPage(),
                'per_page' => $invoices->perPage(),
                'total' => $invoices->total(),
            ],
            'links' => [
                'first' => $invoices->url(1),
                'last' => $invoices->url($invoices->lastPage()),
                'prev' => $invoices->previousPageUrl(),
                'next' => $invoices->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Get specific invoice details.
     */
    public function show(Request $request, int $invoiceId): JsonResponse
    {
        $customer = $request->user()->userable;

        $invoice = $customer->invoices()
            ->with(['lines', 'payments', 'order.items', 'customer'])
            ->findOrFail($invoiceId);

        return response()->json([
            'data' => $invoice
        ]);
    }

    /**
     * Get payment history for a specific invoice.
     */
    public function payments(Request $request, int $invoiceId): JsonResponse
    {
        $customer = $request->user()->userable;

        $invoice = $customer->invoices()->findOrFail($invoiceId);

        $payments = $invoice->payments()
            ->with(['paymentMethod', 'transactions'])
            ->latest()
            ->get();

        return response()->json([
            'data' => $payments
        ]);
    }

    /**
     * Download invoice PDF (placeholder for future implementation).
     */
    public function downloadPdf(Request $request, int $invoiceId): Response
    {
        $customer = $request->user()->userable;

        $invoice = $customer->invoices()->findOrFail($invoiceId);

        // TODO: Implement PDF generation
        // For now, return a placeholder response
        return response()->json([
            'message' => 'PDF download functionality will be implemented in a future update.',
            'invoice_number' => $invoice->invoice_number
        ], 501); // 501 Not Implemented
    }
}
