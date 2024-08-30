<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('api_key', $request->key)->first();

        if(!$user || empty(trim($request->key))){
            return response()->json([
                'error' => 'Invalid API key'
            ], 403);
        }

        $request->attributes->add(['user' => $user]);

        return $next($request);
    }
}
