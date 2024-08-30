<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param int $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, int $role)
    {
        if ($role == 1) {
            // Login Dashboard
            if (Auth::check() && Auth::user()->role == 1 && Auth::user()->status) {
                return $next($request);
            }

            return redirect()->route('panel.auth.formLogin');
        } else if ($role == 2) {
            // Login Panel
            if (Auth::check() && Auth::user()->role == 2) {
                return $next($request);
            }

            return redirect()->route('dashboard.auth.formLogin');
        }
    }
}
