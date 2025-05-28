<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add rate limiting middleware
        $middleware->throttleApi();

        // Custom rate limits for specific routes and user types
        $middleware->alias([
            // Authentication rate limits
            'auth.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':10,1',
            'login.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':5,1',

            // API rate limits
            'api.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1',
            'api.customer.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':30,1',
            'api.admin.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':120,1',

            // Feature-specific rate limits
            'ticket.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':5,1',
            'payment.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':3,1',
            'invoice.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':10,1',

            // Nova-specific rate limits
            'nova.customer.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1',
            'nova.admin.rate_limit' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':200,1',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
