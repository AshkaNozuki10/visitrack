<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
<<<<<<< HEAD
        if (! $request->expectsJson()) {
            return redirect()->route('show.login');
=======
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'Please login to access this page');
>>>>>>> aada54ad073618f04c840f0f888dcfc4f0c7c88e
        }

        return $next($request);
    }
} 
