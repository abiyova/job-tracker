<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            auth()->check()
            && auth()->user()->force_password_change
            && !$request->routeIs('password.change*')
            && !$request->routeIs('logout')
        ) {
            return redirect()->route('password.change.form');
        }
        return $next($request);
    }
}
