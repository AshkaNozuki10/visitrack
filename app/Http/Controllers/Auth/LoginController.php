<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends BaseController    
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create a new controller instance.
     */

    /**
     * Show the login form.
     */

    public function __construct()
    {
        $this->middleware('throttle:3,5')->only(['authenticateUser', 'showLogin']);
    }

    public function showLogin(): View
    {
        return view('auth.login'); // Changed to standard auth.login location
    }

    /**
     * Authenticate the user.
     */
    public function authenticateUser(Request $request): RedirectResponse
    {
        Log::info('Login attempt started', [
            'username' => $request->username,
            'session_id' => session()->getId()
        ]);

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user using username
        if (Auth::attempt([
            'username' => $credentials['username'], 
            'password' => $credentials['password']
        ], $request->filled('remember'))) {
            
            // Get the user before regenerating session
            $user = Auth::user();
            Log::info('Authenticated user object', ['user' => $user, 'user_relationship' => $user->user ?? null, 'role' => $user->user->role ?? null]);
            
            // Regenerate session
            $request->session()->regenerate();
            
            Log::info('Authentication successful', [
                'session_id' => session()->getId(),
                'user_id' => $user->credential_id,
                'auth_id' => Auth::id(),
                'session_data' => session()->all()
            ]);

            // Check user role and redirect accordingly
            Log::info('User authenticated', [
                'user_id' => $user->credential_id,
                'has_info' => $user->user ? true : false,
                'role' => $user->user ? $user->role : 'no role',
                'session_id' => session()->getId()
            ]);

            if ($user->user && $user->user->role === 'admin') {
                Log::info('Redirecting to admin dashboard');
                return redirect()->route('admin.dashboard');
            } else {
                Log::info('Redirecting to visitor dashboard');
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
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
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

    /**
     * Get the login username to be used by the controller.
     */
    public function username(): string
    {
        return 'username';
    }
}