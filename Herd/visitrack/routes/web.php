<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LocationController;
use App\Http\Controllers\LocationService;
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

//Registration Page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register']);

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
});

//Main Dashboard
Route::get('/dashboard', function (){
    return view('main_dashboard');
});

Route::get('/location-test', [LocationService::class, 'test']);
