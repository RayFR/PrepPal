<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordReset
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->force_password_reset) {
            if (
                !$request->routeIs('profile.index') &&
                !$request->routeIs('profile.password') &&
                !$request->routeIs('logout')
            ) {
                return redirect()
                    ->route('profile.index')
                    ->withErrors(['password' => 'For security, please change your password before continuing.']);
            }
        }

        return $next($request);
    }
}