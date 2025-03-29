<?php

namespace App\Http\Middleware;

use Closure;

class RemoveCookies
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->remove('Set-Cookie');
        return $response;
    }
}