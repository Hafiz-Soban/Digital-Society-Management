<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    public function handle(Request $request, Closure $next): Response
    {
<<<<<<< HEAD
        if (Auth::check() && Auth::user()->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
=======
        if (auth()->check() && auth()->user()->status !== 'active') {
            auth()->logout();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            return redirect()->route('login')->with('error', 'Your account has been suspended. Please contact the administrator.');
        }

        return $next($request);
    }
}
