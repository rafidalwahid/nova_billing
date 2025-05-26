<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Customer Dashboard Data
Route::get('/dashboard', function (Request $request) {
    $user = $request->user();
    $customer = $user->userable;

    return response()->json([
        'customer' => [
            'name' => $customer->full_name,
            'email' => $user->email,
            'company' => $customer->company_name,
            'status' => $customer->status ? 'Active' : 'Inactive',
            'member_since' => $customer->created_at->format('M Y'),
        ],
        'stats' => [
            'total_orders' => $customer->orders()->count(),
            'active_subscriptions' => $customer->subscriptions()->where('status', 'active')->count(),
        ],
        'recent_orders' => $customer->orders()->latest()->take(3)->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => $order->total,
                'created_at' => $order->created_at,
            ];
        }),
        'recent_invoices' => $customer->invoices()->latest()->take(3)->get()->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'status' => $invoice->status,
                'total' => $invoice->total,
                'created_at' => $invoice->created_at,
            ];
        }),
        'open_tickets' => $customer->tickets()->whereIn('status', ['open', 'in_progress'])->count(),
    ]);
});

// Customer Orders
Route::get('/orders', function (Request $request) {
    $user = $request->user();
    $customer = $user->userable;

    return response()->json([
        'orders' => $customer->orders()->with(['items', 'invoice'])->latest()->paginate(10),
    ]);
});

// Customer Invoices
Route::get('/invoices', function (Request $request) {
    $user = $request->user();
    $customer = $user->userable;

    return response()->json([
        'invoices' => $customer->invoices()->with(['lines', 'payments'])->latest()->paginate(10),
    ]);
});

// Customer Tickets
Route::get('/tickets', function (Request $request) {
    $user = $request->user();
    $customer = $user->userable;

    return response()->json([
        'tickets' => $customer->tickets()->with(['responses'])->latest()->paginate(10),
    ]);
});
