<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerPortal\CustomerTicketController;

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

// Get customer support tickets - Connect to real database
Route::get('/tickets', [CustomerTicketController::class, 'index']);

// Get single ticket details - Connect to real database
Route::get('/tickets/{id}', [CustomerTicketController::class, 'show']);

// Create new ticket - Connect to real database
Route::post('/tickets', [CustomerTicketController::class, 'store']);

// Debug route to test API
Route::get('/debug', function (Request $request) {
    $user = $request->user();
    $customer = $user->userable;

    $tickets = $customer->tickets()->get();

    return response()->json([
        'debug' => true,
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'is_customer' => $user->isCustomer(),
        ],
        'customer' => [
            'id' => $customer->id,
            'name' => $customer->full_name,
        ],
        'tickets_count' => $tickets->count(),
        'tickets' => $tickets->toArray(),
    ]);
});
