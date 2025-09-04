<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'activity.log' => \App\Http\Middleware\ActivityLogMiddleware::class,
            'service.request.validation' => \App\Http\Middleware\ServiceRequestValidation::class,
        ]);
        
        // Add global middleware
        $middleware->web(append: [
            \App\Http\Middleware\ActivityLogMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Register custom exception handling for ServiceRequestException
        $exceptions->render(function (\App\Exceptions\ServiceRequestException $e, $request) {
            return $e->render($request);
        });
        
        $exceptions->report(function (\App\Exceptions\ServiceRequestException $e) {
            $e->report();
        });
    })->create();
