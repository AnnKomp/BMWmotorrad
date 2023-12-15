<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminType
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            // Verify the account type
            if (auth()->user()->typecompte == 1) {
                return $next($request);
            }
        }

        return response('Accès interdit.', 403);
    }
}
