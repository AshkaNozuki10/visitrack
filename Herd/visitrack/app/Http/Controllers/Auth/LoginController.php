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
            
            // Redirect based on user role
            // Access role through the information relationship
            switch ($user->information->role) {
                case \App\Enums\RoleEnum::ADMIN->value:
                    return redirect()->route('admin.dashboard');
                case \App\Enums\RoleEnum::VISITOR->value:
                    return redirect()->route('visitor.dashboard');
                default:
                    return redirect()->route('home');
            }
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