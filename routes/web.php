<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\QRScanController;
use App\Http\Controllers\VisitorDashboardController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GenerateQr;
use App\Models\Appointment;
use App\Models\QrCode;

// Public routes
//Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

//Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // Changed from 'show.login' to 'login'

//Registration Page
Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('show.register');

//Post method for login and registration
Route::post('/login', [LoginController::class, 'authenticateUser'])->middleware('throttle:3,5')->name('auth.login');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('auth.registration');

//Verification Page
Route::get('/verify', function () {
    return view('auth.verify');
})->name('verify');

//Reset Password Page
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

//Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
}); 

Route::get('/admin/dashboard', function () {
    return view('admin_dashboard');
})->name('admin.dashboard');

Route::get('/visitor/dashboard', [VisitorDashboardController::class, 'index'])
    ->name('visitor.dashboard');

// Temporary testing route - REMOVE BEFORE PRODUCTION
Route::get('/test-visitor-dashboard', function () {
    return view('visitor_dashboard');
})->name('test.visitor.dashboard');

Route::get('/test-admin-dashboard', function () {
    return view('admin_dashboard');
})->name('test.admin.dashboard');

// Debug route - remove in production
Route::get('/auth-debug', function () {
    $result = [
        'is_authenticated' => auth::check(),
    ];
    
    if (auth::check()) {
        $user = auth::user();
        $result['user'] = [
            'id' => $user->id ?? 'No ID',
            'has_information' => isset($user->information),
        ];
        
        if (isset($user->information)) {
            $result['role'] = [
                'value' => $user->information->role,
                'is_admin' => $user->information->role == 'admin',
                'is_visitor' => $user->information->role == 'visitor',
            ];
        }
    }
    
    return response()->json($result);
});

// Location tracking routes
Route::middleware(['auth'])->group(function () {
    Route::post('/location/update', [LocationController::class, 'updateLocationFromFrontend'])->name('location.update');
    Route::get('/location/check', [LocationController::class, 'checkLocationStatus'])->name('location.check');
});

//Appointments from Visitors
Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
Route::post('/qr/scan', [QRScanController::class, 'scan'])->name('qr.scan');
Route::post('/tracking/stop', [QRScanController::class, 'stopTracking'])->name('tracking.stop');

Route::get('/appointment/forms', function () {
    return view('appointments.form');
})->name('appointment.form');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/appointments/approved', [AppointmentController::class, 'getApprovedAppointments'])->name('appointments.approved');
Route::get('/appointments/pending', [AppointmentController::class, 'showPendingAppointments'])->name('appointments.pending');
Route::get('/appointments/rejected', [AppointmentController::class, 'showRejectedAppointment'])->name('appointments.rejected');