<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //when you go login or register route with authenticated then it will send back...
        if (Auth::user()) {
            if (url()->current() == route('auth#login')) {
                return back();
            }
            if (url()->current() == route('auth#register')) {
                return back();
            }
            return $next($request);
        }
        return $next($request);
    }
}
