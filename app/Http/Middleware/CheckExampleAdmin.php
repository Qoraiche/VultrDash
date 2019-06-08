<?php

namespace vultrui\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckExampleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && $request->user()->id === 1 && $request->user()->email === 'admin@example.com' && !$request->user()->hasRole('super-admin')) {
            $request->user()->assignRole('super-admin');

            return redirect('/');
        }

        return $next($request);
    }
}
