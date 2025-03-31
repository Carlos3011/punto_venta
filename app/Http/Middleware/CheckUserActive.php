<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->isActive()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Tu cuenta está desactivada. Por favor, contacta al administrador.');
        }

        return $next($request);
    }
}