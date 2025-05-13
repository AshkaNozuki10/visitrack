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
        Log::info('Admin middleware check', [
            'authenticated' => Auth::check(),
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

        if(Auth::check()){
            $user = Auth::user();
            $role = $user->information ? $user->information->role : 'no role';
            Log::info('User role check', ['role' => $role]);

            if($role === 'admin') {
                Log::info('Admin access granted');
                return $next($request);
            }
            else{
                Log::warning('Admin access denied', ['role' => $role]);
                return redirect('/')->with('status', 'Access denied: Admin privileges required');
            }
        }
        else{
            Log::warning('Admin middleware: User not authenticated');
            return redirect('/login')->with('status', 'Please login to access this page');
        }
    }
}
