<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->role_id === 2) {
                return $next($request);
            }
            abort(403, 'Accès refusé');
        }

        return redirect()->route('login');
    }
}
