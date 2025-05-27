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

// Default route - redirect to Nova customer dashboard
Route::get('/', function (NovaRequest $request) {
    return redirect('/nova/dashboards/customer-dashboard');
});

// Dashboard functionality moved to Nova dashboard
// Route::get('/dashboard', ...) - REMOVED

// Tickets route
Route::get('/tickets', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});

// Profile route
Route::get('/profile', function (NovaRequest $request) {
    return inertia('CustomerPortal');
});
