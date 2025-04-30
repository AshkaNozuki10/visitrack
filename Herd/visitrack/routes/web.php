<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;

Route::get('/example', function () {
    return view('welcome');
});

//Homepage
Route::get('/', function () {
    return view('home');
});

//Login Page
Route::get('/login', function () {
    return view('login');
});

//Get method for login and registration
Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('show.register');
Route::get('/login', [LoginController::class, 'showLogin'])->name('show.login');

//Post method for login and registration
Route::post('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');

//Logout
Route::post('/login', [LoginController::class, 'logOut'])->name('logout');

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

Route::get('/location-test', [LocationService::class, 'test']);

//Test the csrf token
Route::get('/test-csrf', function() {
    return csrf_token(); // Should return a token
});