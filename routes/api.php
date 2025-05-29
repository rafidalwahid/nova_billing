<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerPortal\CustomerTicketController;
use App\Http\Controllers\CustomerPortal\CustomerProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Customer Portal API Routes
|--------------------------------------------------------------------------
|
| These routes are for customer-facing API endpoints that allow customers
| to manage their tickets, profile, and other account-related functionality.
| All routes require authentication and customer role verification.
|
*/

Route::middleware(['auth:web', 'api.customer.rate_limit'])->prefix('customer-portal')->name('customer-portal.')->group(function () {

    // Customer Profile Routes
    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [CustomerProfileController::class, 'changePassword'])->name('profile.change-password');

    // Customer Support Ticket Routes
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [CustomerTicketController::class, 'index'])->name('index');
        Route::post('/', [CustomerTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [CustomerTicketController::class, 'show'])->name('show');
        Route::get('/{ticket}/responses', [CustomerTicketController::class, 'getResponses'])->name('responses');
        Route::post('/{ticket}/responses', [CustomerTicketController::class, 'addResponse'])->name('add-response');
        Route::post('/{ticket}/attachments', [CustomerTicketController::class, 'uploadAttachment'])->name('upload-attachment');
    });

    // Customer Statistics/Dashboard Data (future expansion)
    Route::get('/dashboard-stats', function (Request $request) {
        $customer = $request->user()->userable;

        return response()->json([
            'data' => [
                'total_tickets' => $customer->tickets()->count(),
                'open_tickets' => $customer->tickets()->where('status', 'open')->count(),
                'total_orders' => $customer->orders()->count(),
                'active_subscriptions' => $customer->subscriptions()->where('status', 'active')->count(),
            ]
        ]);
    })->name('dashboard-stats');
});
