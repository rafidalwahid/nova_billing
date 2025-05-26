<?php

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

// Default route - redirect to dashboard
Route::get('/', function (NovaRequest $request) {
    return redirect('/nova/customer-portal/dashboard');
});

// Dashboard route
Route::get('/dashboard', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});

// Orders route
Route::get('/orders', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});

// Invoices route
Route::get('/invoices', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});

// Tickets route
Route::get('/tickets', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});
