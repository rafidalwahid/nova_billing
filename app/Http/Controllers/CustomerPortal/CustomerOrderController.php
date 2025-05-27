<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerOrderController extends Controller
{
    /**
     * Get customer orders with pagination and filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $customer = $request->user()->userable;

        $query = $customer->orders()
            ->with(['items.product', 'invoice.payments']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('order_number', 'like', "%{$searchTerm}%")
                  ->orWhere('notes', 'like', "%{$searchTerm}%")
                  ->orWhereHas('items', function ($itemQuery) use ($searchTerm) {
                      $itemQuery->where('product_name', 'like', "%{$searchTerm}%")
                               ->orWhere('description', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $allowedSortFields = ['created_at', 'order_number', 'status', 'total'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest();
        }

        $perPage = min($request->get('per_page', 10), 50); // Max 50 items per page
        $orders = $query->paginate($perPage);

        return response()->json([
            'data' => $orders->items(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ],
            'links' => [
                'first' => $orders->url(1),
                'last' => $orders->url($orders->lastPage()),
                'prev' => $orders->previousPageUrl(),
                'next' => $orders->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Get specific order details.
     */
    public function show(Request $request, int $orderId): JsonResponse
    {
        $customer = $request->user()->userable;

        $order = $customer->orders()
            ->with(['items.product', 'invoice.payments', 'customer'])
            ->findOrFail($orderId);

        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Get order items for a specific order.
     */
    public function items(Request $request, int $orderId): JsonResponse
    {
        $customer = $request->user()->userable;

        $order = $customer->orders()->findOrFail($orderId);

        $items = $order->items()
            ->with(['product', 'productPricing'])
            ->get();

        return response()->json([
            'data' => $items
        ]);
    }
}
