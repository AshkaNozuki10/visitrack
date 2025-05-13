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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecurityGuardController;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;

// Public routes
//Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [LoginController::class, 'authenticateUser'])->name('auth.login');
Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('show.register');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('auth.register');

//Forgot Password Page
Route::get('/forgot-password', function () {
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

//Testing the post method
Route::get('test-register', [RegisteredUserController::class, 'testRegister'])->name('test.register');

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
}); 

// Role-protected routes
// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/visitors', [AdminController::class, 'visitors'])->name('admin.visitors');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/blacklist', [AdminController::class, 'blacklist'])->name('admin.blacklist');
    Route::post('/blacklist/{information}', [AdminController::class, 'addToBlacklist'])->name('admin.blacklist.add');
    Route::delete('/blacklist/{information}', [AdminController::class, 'removeFromBlacklist'])->name('admin.blacklist.remove');
    Route::post('/visits/{visit}/checkout', [AdminController::class, 'checkOut'])->name('admin.visits.checkout');
});

// Visitor routes
Route::middleware(['auth', 'visitor'])->group(function () {
    Route::get('/visitor-dashboard', function () {
        return view('visitor.visitor_dashboard');
    })->name('visitor.dashboard');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Location tracking routes
    Route::post('/location/update', [LocationController::class, 'updateLocationFromFrontend'])->name('location.update');
    Route::get('/location/check', [LocationController::class, 'checkLocationStatus'])->name('location.check');
    
    // Appointment routes
    // Appointment form route
    Route::get('/appointments/form', [AppointmentController::class, 'showAppointmentForm'])->name('appointment.form');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');;
    Route::get('/appointments/print', [AppointmentController::class, 'printAppointments'])->name('print.appointments');

    //Approved, Rejected and Pending Appointments
    Route::get('/appointments/approved', [AppointmentController::class, 'showApprovedAppointments'])->name('show.approved.appointments');
    Route::get('/appointments/rejected', [AppointmentController::class, 'showRejectedAppointments'])->name('show.rejected.appointments');
    Route::get('/apppointments/pending', [AppointmentController::class, 'showPendingAppointments'])->name('show.pending.appointments');
});

// Security Guard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/security/dashboard', [SecurityGuardController::class, 'dashboard'])->name('security.dashboard');
    Route::post('/security/check-in', [SecurityGuardController::class, 'checkIn'])->name('security.check-in');
    Route::post('/security/check-out', [SecurityGuardController::class, 'checkOut'])->name('security.check-out');
});

// QR Scanner routes (for admin and guard)
Route::middleware(['auth'])->group(function () {
    Route::get('/qr-scanner', [QrScannerController::class, 'index'])->name('qr-scanner.index');
    Route::get('/verify-qr/{code}', [QrScannerController::class, 'verify'])->name('qr-scanner.verify');
});