<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $type
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (auth()->check() && auth()->user()->userType?->name === $type) {
            return $next($request);
        }

        abort(403, 'Accesso negato.');
    }
}
