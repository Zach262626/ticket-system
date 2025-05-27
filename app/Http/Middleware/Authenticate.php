<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request is for a tenant domain
        if ($request->route('tenant')) {
            return route('user-login'); // Define this route in your tenant routes
        }

        return route('login'); // Central login route
    }
}
