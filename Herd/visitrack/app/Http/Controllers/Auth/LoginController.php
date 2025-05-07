<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    /*
    public function __construct()
    {
        $this->middleware('student')->except('logout');
    }
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
        $credentials = $request->validate([
            'username' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();  

            $user = Auth::user();
            
            // Add debug logging
            \Log::info('User authenticated', [
                'user_id' => $user->credential_id,
                'has_information' => $user->information ? 'yes' : 'no',
                'role' => $user->information->role ?? 'undefined'
            ]);
            
            // Redirect based on user role
            try {
                switch ($user->information->role) {
                    case 'admin': // Changed from RoleEnum::ADMIN->value to string
                        return redirect()->route('admin.dashboard');
                    case 'visitor': // Changed from RoleEnum::VISITOR->value to string
                        return redirect()->route('visitor.dashboard');
                    default:
                        return redirect()->route('home');
                }
            } catch (\Exception $e) {
                \Log::error('Error during role redirect', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->route('home')->with('error', 'Role assignment error');
            }
        }

        // Return with a user-friendly error message instead of throwing an exception
        return redirect()->back()
            ->withInput($request->except('password'))
            ->with('error', 'Invalid credentials. Please check your username and password and try again.');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
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