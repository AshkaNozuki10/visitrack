<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SecurityGuardController;
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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show.login');

//Registration Page
Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('show.register');

//Post method for login and registration
Route::post('/login', [LoginController::class, 'authenticateUser'])->middleware('throttle:120,1')->name('auth.login');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('auth.registration');

//Forgot Password Page
Route::get('/forgotpass', function () {
    return view('auth.forgot_password');
})->name('forgot.password');

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

// Role-protected routes
// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function(){
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');

});

// Visitor routes
Route::middleware(['auth', 'visitor'])->group(function () {
    Route::get('/visitor/dashboard', function () {
        return view('visitor.visitor_dashboard');
    })->name('visitor.dashboard');

    //Appointments
    Route::get('/visitor/appointment/forms', function () {
    return view('appointments.form');
    })->name('appointment.form');

    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');

    //Approved, Rejected, and Pending
    Route::get('/visitor/appointments/approved', [AppointmentController::class, 'getApprovedAppointments'])->name('appointments.approved');
    Route::get('/visitor/appointments/pending', [AppointmentController::class, 'showPendingAppointments'])->name('appointments.pending');
    Route::get('/visitor/appointments/rejected', [AppointmentController::class, 'showRejectedAppointments'])->name('appointments.rejected');
    Route::get('/visitor/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
});

//Test the csrf token
Route::get('/test-csrf', function() {
    return csrf_token(); // Should return a token
});

//Test the qr code
Route::get('/test-generate-qr', [GenerateQr::class, 'generateQrContent']);

// Temporary testing route - REMOVE BEFORE PRODUCTION
Route::get('/test-visitor-dashboard', function () {
    return view('visitor.visitor_dashboard');
})->name('test.visitor.dashboard');

// Debug route
Route::get('/debug-auth', function () {
    if (Auth::check()) {
        $user = Auth::user();
        try {
            $info = $user->user;
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
    Route::get('/visitortracking', [App\Http\Controllers\VisitorTrackingController::class, 'dashboard'])->name('visitor.tracking');
    Route::post('/location/update', [LocationController::class, 'updateLocationFromFrontend'])->name('location.update');
    Route::get('/location/check', [LocationController::class, 'checkLocationStatus'])->name('location.check');
});

// Appointment and QR routes
Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');

//Admin Route
Route::middleware(['auth', 'admin'])->group(function () {
    // Show admin dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    //Visitor Traccking
    Route::get('/admin/visitor-tracking', [App\Http\Controllers\AdminDashboardController::class, 'visitorTracking'])->name('admin.visitor-tracking');

    //Appointments
    Route::get('/admin/approved-appointments', [App\Http\Controllers\AdminDashboardController::class, 'approvedAppointments'])->name('admin.approved.appointments');
    Route::get('/admin/rejected-appointments', [App\Http\Controllers\AdminDashboardController::class, 'rejectedAppointments'])->name('admin.rejected.appointments');
    Route::get('/admin/pending-appointments', [App\Http\Controllers\AdminDashboardController::class, 'pendingAppointments'])->name('admin.pending.appointments');

    //Admin Reports
    Route::get('/admin/reports', [App\Http\Controllers\AdminReportsController::class, 'showReports'])->name('admin.reports');

    //Admin Account Settings
    Route::get('/admin/settings', [App\Http\Controllers\AdminSettingsController::class, 'settings'])->name('admin.settings');

    //QR Scan
    Route::post('/qr/scan', [QRScanController::class, 'scan'])->name('qr.scan');
    Route::post('/tracking/stop', [QRScanController::class, 'stopTracking'])->name('tracking.stop');
});

//Guard Route