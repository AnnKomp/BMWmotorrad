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

        // Return to the login page
        //return redirect()->route('login');

        // Retuturn an error with Denied Acess
        abort(403, 'Accès interdit');
    }
}
