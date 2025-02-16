<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                if ($user->hasRole('admin')) {
                    return redirect()->intended(RouteServiceProvider::ADMIN);
                } elseif ($user->hasRole('customer')) {
                    return redirect()->intended(RouteServiceProvider::CUSTOMER);
                } else {
                    return redirect()->intended(RouteServiceProvider::CUSTOMER);
                }
            }
        }
        return $next($request);
    }
}
