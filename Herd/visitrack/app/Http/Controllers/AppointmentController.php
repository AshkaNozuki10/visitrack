<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Controllers\GenerateQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    protected $qrGenerator;

    public function __construct(GenerateQr $qrGenerator)
    {
        $this->qrGenerator = $qrGenerator;
    }

    public function approve(Appointment $appointment)
    {
        // Update appointment status to approved
        $appointment->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        // Generate QR code automatically
        try {
            $qrCode = $this->qrGenerator->generateForAppointment($appointment);
            return response()->json([
                'message' => 'Appointment approved and QR code generated successfully',
                'qr_code' => $qrCode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Appointment approved but QR code generation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}