<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonStudentMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->role_as == 'non_student') {
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
