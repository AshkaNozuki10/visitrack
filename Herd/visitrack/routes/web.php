<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerateQr;
use App\Models\appointment;

//Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

//Login Page
Route::get('/login', function () {
    return view('auth.login');
});

//Registration Page
Route::get('/register', function () {
    return view('auth.registration');
});

//Get method for login and registration
Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('show.register');
Route::get('/login', [LoginController::class, 'showLogin'])->name('show.login');

//Post method for login and registration
Route::post('/login', [LoginController::class, 'authenticateUser'])->name('auth.login');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('auth.registration');

//Logout
Route::post('/logout', [LoginController::class, 'logOut'])->name('logout');

//Testing the post method
Route::get('test-register', [RegisteredUserController::class, 'testRegister'])->name('test.register');

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
}); 

//Main Dashboard
Route::get('/dashboard', function (){
    return view('main_dashboard');
});

Route::get('/location-test', [LocationController::class, 'test']);

//Test the csrf token
Route::get('/test-csrf', function() {
    return csrf_token(); // Should return a token
});

//Test the qr code
Route::get('/test-generate-qr', [GenerateQr::class, 'generateQrContent']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');