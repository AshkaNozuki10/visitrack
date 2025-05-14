<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Credential;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.registration');
    }

    public function register(Request $request){
        Log::info('Registration attempt started', ['request' => $request->all()]);
        
        // Force role to be visitor
        $request->merge(['role' => 'visitor']);
        
        $validated = $request->validate([
            'last_name' => 'required|string|max:55',
            'first_name' => 'required|string|max:55',
            'middle_name' => 'nullable|string|max:55',
            'sex' => 'required|in:male,female',
            'birthdate' => 'required|date|before:today',
            'role' => 'required|in:visitor', // Only allow visitor role
            'street_no' => 'required|string|max:20',
            'street_name' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'email' => 'required|email|unique:credential,email',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // First create user information
            $information = Information::create([
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'sex' => $validated['sex'],
                'birthdate' => $validated['birthdate'],
                'role' => $validated['role'],
            ]);

            // Create credential with the correct user_id
            $credential = Credential::create([
                'user_id' => $information->user_id,
                'username' => $validated['email'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Create address with the correct user_id
            Address::create([
                'user_id' => $information->user_id,
                'street_no' => $validated['street_no'],
                'street_name' => $validated['street_name'],
                'barangay' => $validated['barangay'],
                'district' => $validated['district'],
                'city' => $validated['city'],
            ]);

            DB::commit();
            Log::info('Registration successful', ['user_id' => $information->user_id]);

            return redirect()
                ->route('login')
                ->with('status', 'Registration successful! Please login.');

        } catch(\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollback();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    //Test if there's data submitted
    public function testRegister(Request $request) {
        dd($request->all());
    }
}