<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role_as == 'student') {
                return $next($request);
            }
            else{
                return redirect('/')->with('status', 'You are not allowed to access this page');
            }
        }

        else{
            return redirect('/login')->with('status', 'Please login to access this page');
        }

    }
}
