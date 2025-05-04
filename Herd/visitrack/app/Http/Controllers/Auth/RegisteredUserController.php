<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Credential;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.registration'); //Registration View
   }

   public function register(Request $request){

    \Log::info('Registration attempt started', ['request' => $request->all()]);
    
    $validated = $request->validate([
        'last_name' => 'required|string|max:55',
        'first_name' => 'required|string|max:   55',
        'middle_name' => 'nullable|string|max:55', //Allow null
        'sex' => 'required|in:male,female', //Enum values
        'birthdate' => 'required|date|before:today',
        'role' => 'required|in:student,non_student,contractor,faculty,admin',
        'username' => 'required|email|unique:credential,username', // Using username field for email
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
    ]);

    \Log::info('Validation passed', ['validated' => $validated]);

    //Start database transaction
    DB::beginTransaction();

    try{
        \Log::info('Creating user information');
        //Create user information
        Information::create([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'sex' => $validated['sex'],
            'birthdate' => $validated['birthdate'],
            'role' => $validated['role'],
        ]);

        //Create credentials
        Credential::create([
            'user_id' => $validated['user_id'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);


        \Log::info('Creating Address for the user');
        Address::create([
            'user_id' => $validated['user_id'],
            'street_no' => $validated['street_no'],
            'street_name' => $validated['street_name'],
            'barangay' => $validated['barangay'],
            'district' => $validated['district'],
            'city' => $validated['city'],
        ]);

        //Commit transaction
        DB::commit();
        \Log::info('Transaction committed successfully');

        return redirect()->route('show.login')->with('success', 'Registration successful!');
    }
    catch(\Exception $e){
        \Log::error('Registration failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        //Rollback transaction on error
        DB::rollback();
        return back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
    }

    /*
    DB::transaction(function () use ($request){
        //Create User

        $user = TblCredential::create([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        //User's Information
        TblInformation::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'sex' => ucfirst($request->sex),
            'birthdate' => $request->birthdate,
            ]);

            //User's Address
            TblAddress::create([
                'user_id' => $user->user_id,
                'street_no' => $user->street_no,
                'street_name' => $user->street_name,
                'barangay' => $user->barangay,
                'district' => $user->district,
                'city' => $user->city
            ]);

            //Login
            Auth::login($user);
        });

        return redirect()->route('login');
        */
    }

    //Test if there's data submitted
    public function testRegister(Request $request) {
        dd($request->all()); // This should show submitted data
        // If you don't see this, the request isn't reaching your controller
    }
}