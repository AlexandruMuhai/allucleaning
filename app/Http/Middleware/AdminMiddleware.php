<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdministrator()) {
            abort(403, 'Brak dostępu. Wymagane uprawnienia administratora.');
        }

        return $next($request);
    }
}
