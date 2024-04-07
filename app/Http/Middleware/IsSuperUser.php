<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user exists and has role ID equal to 1
        if ($user && $user->role_id == 1) {
            // User is a superuser, allow the request to continue
            return $next($request);
        }

        // User is not a superuser, deny access
        abort(403, 'Access denied');
    }
}
