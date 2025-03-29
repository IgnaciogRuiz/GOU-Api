<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class SkipCsrfMiddleware extends Middleware
{
    protected $except = [
        '*', // Deshabilita CSRF en todas las rutas
    ];
}
