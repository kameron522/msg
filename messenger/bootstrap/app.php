<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function() {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/users.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/messages.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Barryvdh\HttpCache\Middleware\CacheRequests::class);
        $middleware->alias([
            'ttl' => \Barryvdh\HttpCache\Middleware\SetTtl::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
