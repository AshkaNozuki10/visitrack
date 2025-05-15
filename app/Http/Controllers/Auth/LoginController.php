<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Handle the login request
     */
    public function authenticateUser(Request $request)
    {
        Log::info('Login attempt started', [
            'username' => $request->username,
            'session_id' => session()->getId()
        ]);

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Clear any existing session data
        Session::flush();
        
        // Attempt to authenticate the user using username
        if (Auth::attempt([
            'username' => $credentials['username'], 
            'password' => $credentials['password']
        ], $request->filled('remember'))) {
            
            // Get the user before regenerating session
            $user = Auth::user();
            
            // Regenerate session
            $request->session()->regenerate();
            
            Log::info('Authentication successful', [
                'user_id' => $user->credential_id,
                'has_info' => $user->user ? true : false,
                'role' => $user ? $user->role : 'no role',
                'session_id' => session()->getId()
            ]);

            $user = Auth::user();
            $role = $user->user->role;

            if ($role === 'admin'){
                return redirect()->route('admin.dashboard');
            }
            elseif ($role === 'guard'){
                return redirect()->route('guard.dashboard');
            }
            else{
                return redirect()->route('visitor.dashboard');
            }
        }

        Log::warning('Authentication failed', [
            'username' => $request->username,
            'session_id' => session()->getId()
        ]);
        
        // Authentication failed
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Log::info('Logout attempt', [
            'user_id' => Auth::id(),
            'session_id' => session()->getId()
        ]);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}