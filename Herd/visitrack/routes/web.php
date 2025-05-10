<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\QRScanController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerateQr;
use App\Models\appointment;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Auth;

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

//Forgot Password Page
Route::get('/forgotpass', function () {
    return view('auth.forgotpass');
})->name('forgotpass');

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

//Testing the post method
Route::get('test-register', [RegisteredUserController::class, 'testRegister'])->name('test.register');

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
}); 

// Role-protected routes
// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
// Visitor routes
Route::middleware(['auth', 'visitor'])->group(function () {
    Route::get('/visitor-dashboard', function () {
        return view('visitor_dashboard');
    })->name('visitor.dashboard');

    // Add other visitor routes here
});

//Test the csrf token
Route::get('/test-csrf', function() {
    return csrf_token(); // Should return a token
});

//Test the qr code
Route::get('/test-generate-qr', [GenerateQr::class, 'generateQrContent']);

// Temporary testing route - REMOVE BEFORE PRODUCTION
Route::get('/test-visitor-dashboard', function () {
    return view('visitor_dashboard');
})->name('test.visitor.dashboard');

// Debug route
Route::get('/debug-auth', function () {
    if (Auth::check()) {
        $user = Auth::user();
        try {
            $info = $user->information;
            $role = $info ? $info->role : 'No role found';
            
            return [
                'authenticated' => true,
                'user_id' => $user->credential_id,
                'has_info' => $info ? true : false,
                'role' => $role,
                'redirect_url' => $role === 'admin' ? route('admin.dashboard') : route('visitor.dashboard')
            ];
        } catch (\Exception $e) {
            return [
                'authenticated' => true, 
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }
    
    return ['authenticated' => false];
})->name('debug.auth');

// Location tracking routes
Route::middleware(['auth'])->group(function () {
    Route::post('/location/update', [LocationController::class, 'updateLocationFromFrontend'])->name('location.update');
    Route::get('/location/check', [LocationController::class, 'checkLocationStatus'])->name('location.check');
});

// Appointment and QR routes
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
