<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateSanctumToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            Auth::guard('sanctum');
            $user = auth('sanctum')->user();

            if ($user) {
                Auth::setUser($user);
            }
        }

        return $next($request);
    }
}
