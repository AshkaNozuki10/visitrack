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
use Illuminate\Routing\Middleware\ThrottleRequests;

class LoginController extends Controller    
{
    use AuthorizesRequests, ValidatesRequests, ThrottleRequests;

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
            'email' => $credentials['username'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();  

            $user = Auth::user();

            if($user->role === 'admin'){
                return redirect()->route('admin.dashboard');
            } 
            
            elseif($user->role === 'student'){
                return redirect()->route('student.dashboard');
            }

            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
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