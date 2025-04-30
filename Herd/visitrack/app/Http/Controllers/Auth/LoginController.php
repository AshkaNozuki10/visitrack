<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller    
{
    public function showLogin(){
        return view('login');
    }

    public function authenticateUser(Request $request){
        $validated = $request->validate([
            'username' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials, $request->filled('remember'))){
            $request->session()->regenerate();

            return redirect()->intended('main_dashboard');
        }

        throw ValidationException::withMessage([
            'username' => [trans('auth.failed')],
        ]);

    }

    public function logOut(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToke();

        return redirect('/');
    }
}
