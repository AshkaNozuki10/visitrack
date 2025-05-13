<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\QrCode;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class QrScannerController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,security_guard']);
    }

    public function index()
    {
        return view('qr-scanner.index');
    }

    public function verify($code)
    {
        try {
            $qrCode = QrCode::where('qr_id', $code)->first();

            if (!$qrCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code. Appointment not registered.'
                ]);
            }

            $appointment = Appointment::with('user')
                ->where('qr_code', $qrCode->qr_id)
                ->first();

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'No appointment found for this QR code.'
                ]);
            }

            if ($appointment->approval !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment has not been approved.'
                ]);
            }

            // Check if the appointment is for today
            if (\Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') !== now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment is not scheduled for today.'
                ]);
            }

            return response()->json([
                'success' => true,
                'appointment' => [
                    'user' => [
                        'name' => $appointment->user->name
                    ],
                    'purpose' => $appointment->purpose,
                    'department' => $appointment->department,
                    'appointment_date' => \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y'),
                    'appointment_time' => \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error verifying QR code: ' . $e->getMessage()
            ], 500);
        }
    }
} 