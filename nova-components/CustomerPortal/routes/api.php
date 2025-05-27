<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerPortal\CustomerOrderController;
use App\Http\Controllers\CustomerPortal\CustomerInvoiceController;
use App\Http\Controllers\CustomerPortal\CustomerServiceController;
use App\Http\Controllers\CustomerPortal\CustomerTicketController;
use App\Http\Controllers\CustomerPortal\CustomerProfileController;

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

// Dashboard functionality moved to Nova dashboard and metrics
// Route::get('/dashboard', ...) - REMOVED

// Orders Routes
Route::get('/orders', [CustomerOrderController::class, 'index']);
Route::get('/orders/{id}', [CustomerOrderController::class, 'show']);
Route::get('/orders/{id}/items', [CustomerOrderController::class, 'items']);

// Invoices Routes
Route::get('/invoices', [CustomerInvoiceController::class, 'index']);
Route::get('/invoices/{id}', [CustomerInvoiceController::class, 'show']);
Route::get('/invoices/{id}/payments', [CustomerInvoiceController::class, 'payments']);
Route::get('/invoices/{id}/pdf', [CustomerInvoiceController::class, 'downloadPdf']);

// Services Routes
Route::get('/services', [CustomerServiceController::class, 'index']);
Route::get('/hosting-accounts', [CustomerServiceController::class, 'hostingAccounts']);
Route::get('/domains', [CustomerServiceController::class, 'domains']);
Route::get('/subscriptions', [CustomerServiceController::class, 'subscriptions']);

// Support Tickets Routes
Route::get('/tickets', [CustomerTicketController::class, 'index']);
Route::post('/tickets', [CustomerTicketController::class, 'store']);
Route::get('/tickets/{id}', [CustomerTicketController::class, 'show']);
Route::post('/tickets/{id}/responses', [CustomerTicketController::class, 'addResponse']);
Route::post('/tickets/{id}/attachments', [CustomerTicketController::class, 'uploadAttachment']);

// Profile Routes
Route::get('/profile', [CustomerProfileController::class, 'show']);
Route::put('/profile', [CustomerProfileController::class, 'update']);
Route::put('/profile/password', [CustomerProfileController::class, 'changePassword']);
