<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\QrCode;

class VisitorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('show.login');
        }
        $appointment = Appointment::where('user_id', $user->user_id)
            ->orderByDesc('created_at')
            ->first();
        $qr = null;
        $status = null;
        $message = null;

        if (!$appointment) {
            $status = 'no_appointment';
            $message = 'Please make an appointment and wait for admin approval.';
        } elseif ($appointment->approval === 'pending') {
            $status = 'pending';
            $message = 'Your appointment is pending approval.';
        } elseif ($appointment->approval === 'approved') {
            $qr = QrCode::where('appointment_id', $appointment->appointment_id)->first();
            if (!$qr) {
                $status = 'approved_no_qr';
                $message = 'Your appointment is approved. Please wait while your QR code is being generated.';
            } else {
                $status = 'approved_with_qr';
                $message = 'Your appointment is approved. Please scan your QR code to verify entry.';
            }
        } elseif ($appointment->approval === 'rejected') {
            $status = 'rejected';
            $message = 'Your appointment was rejected. Please make a new appointment.';
        }

        return redirect()->route('visitor.dashboard', [
            'appointment' => $appointment,
            'qr' => $qr,
            'status' => $status,
            'message' => $message,
        ]);
    }
}