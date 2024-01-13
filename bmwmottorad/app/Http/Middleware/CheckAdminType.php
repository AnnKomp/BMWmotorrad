<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminType
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            // Verify the account type
            if (auth()->user()->typecompte == 1) {
                return $next($request);
            }
        }

        // Return to the login page
        //return redirect()->route('login');

        // Return an error with Denied Access
        abort(403, 'Accès interdit');
    }
}
