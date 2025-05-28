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
Route::get('/tickets', [CustomerTicketController::class, 'index'])
    ->middleware('throttle:60,1'); // 60 requests per minute

// Get single ticket details - Connect to real database
Route::get('/tickets/{id}', [CustomerTicketController::class, 'show'])
    ->middleware('throttle:120,1'); // 120 requests per minute

// Create new ticket - Connect to real database (rate limited)
Route::post('/tickets', [CustomerTicketController::class, 'store'])
    ->middleware('throttle:5,1'); // 5 ticket creations per minute

// Get ticket responses - Connect to real database
Route::get('/tickets/{id}/responses', [CustomerTicketController::class, 'getResponses'])
    ->middleware('throttle:120,1'); // 120 requests per minute

// Add response to ticket - Connect to real database (rate limited)
Route::post('/tickets/{id}/responses', [CustomerTicketController::class, 'addResponse'])
    ->middleware('throttle:10,1'); // 10 responses per minute

// Upload attachment to ticket - Connect to real database (rate limited)
Route::post('/tickets/{id}/attachments', [CustomerTicketController::class, 'uploadAttachment'])
    ->middleware('throttle:5,1'); // 5 uploads per minute
