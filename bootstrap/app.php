<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RemoveCookies;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Middleware para eliminar cookies en todas las respuestas
        $middleware->prepend(RemoveCookies::class);

        // Mantener Sanctum para API Tokens
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Redefinir el grupo 'web' sin CSRF, sesiones ni cookies
        $middleware->group('web', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Excluir CSRF en rutas específicas
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'csrf_exempt' => \App\Http\Middleware\SkipCsrfMiddleware::class, // Paso 2
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

