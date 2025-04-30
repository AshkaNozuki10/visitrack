<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TblAddress;
use App\Models\TblCredential;
use App\Models\TblInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function showRegistrationForm(){
        return view('registration'); //Registration View
   }

   public function register(Request $request){
    $validated = $request->validate([
        'lastname' => 'required|string|max:55',
        'first_name' => 'required|string|max:55',
        'middle_name' => 'nullable|string|max:55', //Allow null
        'sex' => 'required|in:male, female', //Enum values
        'birthdate' => 'required|date|before:today',
        'role' => 'required|in:student, non_visitor, contractor, faculty, admin',
        'username' => 'required|email|unique:tbl_credential,username', // Using username field for email
        'password' => 'required|min:8|confirmed',
    ]);

    //Start database transaction
    DB::beginTransaction();

    try{
        //Create user information
        $userInfo = TblInformation::create([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'sex' => $validated['sex'],
            'birth_date' => $validated['birth_date'],
            'role' => $validated['role'],
        ]);

        //Create credentials
        $credential = TblCredential::create([
            'user_id' => $userInfo->user_id,
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        //Commit transaction
        DB::commit();

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    catch(\Exception $e){
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