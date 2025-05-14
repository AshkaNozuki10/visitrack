<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\RoleEnum;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->user === 'admin') {
                return $next($request);
            }
            else{
                return redirect('/')->with('status', 'Access denied: Visitor privileges required');
            }
        }
        else{
            return redirect('/login')->with('status', 'Please login to access this page');
        }
    }
}
