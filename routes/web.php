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
<<<<<<< HEAD
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecurityGuardController;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
=======
use App\Http\Controllers\AdminDashboardController;
>>>>>>> aada54ad073618f04c840f0f888dcfc4f0c7c88e
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

//Testing the post method
Route::get('test-register', [RegisteredUserController::class, 'testRegister'])->name('test.register');

//Testing the post method
Route::get('test-register', [RegisteredUserController::class, 'testRegister'])->name('test.register');

//Database Connection
Route::get('/db-test', function () {
    return view('database_test');
}); 

// Role-protected routes
// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
<<<<<<< HEAD
    Route::get('/admin-dashboard', function () {
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');
=======
    Route::get('admin/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
>>>>>>> aada54ad073618f04c840f0f888dcfc4f0c7c88e
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

<<<<<<< HEAD
// QR Scanner routes (for admin and guard)
Route::middleware(['auth'])->group(function () {
    Route::get('/qr-scanner', [QrScannerController::class, 'index'])->name('qr-scanner.index');
    Route::get('/verify-qr/{code}', [QrScannerController::class, 'verify'])->name('qr-scanner.verify');
});
=======
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
Route::post('/appointments/{appointment}/reject', [App\Http\Controllers\AppointmentController::class, 'reject'])->name('appointments.reject');

Route::get('/appointment/forms', function () {
    return view('appointments.form');
})->name('appointment.form');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');

Route::get('/appointments/approved', [AppointmentController::class, 'getApprovedAppointments'])->name('appointments.approved');
Route::get('/appointments/pending', [AppointmentController::class, 'showPendingAppointments'])->name('appointments.pending');
Route::get('/appointments/rejected', [AppointmentController::class, 'showRejectedAppointment'])->name('appointments.rejected');
Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/visitor-tracking', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.visitor-tracking');
    Route::get('/approved-appointments', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.approved-appointments');
    Route::get('/rejected-appointments', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.rejected-appointments');
    Route::get('/pending-appointments', [App\Http\Controllers\AdminDashboardController::class, 'pendingAppointmentsForAdmin'])->name('admin.pending-appointments');
    Route::get('/reports', [App\Http\Controllers\AdminReportsController::class, 'index'])->name('admin.reports');
    Route::get('/settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('admin.settings');
});
>>>>>>> aada54ad073618f04c840f0f888dcfc4f0c7c88e
