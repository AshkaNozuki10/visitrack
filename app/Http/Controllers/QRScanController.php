<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QRScanController extends Controller
{
    protected $visitController;

    public function __construct(VisitController $visitController)
    {
        $this->visitController = $visitController;
    }

    public function scan(Request $request)
    {
        $qrContent = json_decode($request->input('qr_content'), true);
        
        if (!$qrContent || !isset($qrContent['appointment_id'])) {
            return response()->json(['error' => 'Invalid QR code'], 400);
        }

        // Verify QR code exists and is valid
        $qrCode = QrCode::where('qr_text', json_encode($qrContent))->first();
        if (!$qrCode) {
            return response()->json(['error' => 'QR code not found'], 404);
        }

        // Get appointment
        $appointment = Appointment::find($qrContent['appointment_id']);
        if (!$appointment || !$appointment->is_approved()) {
            return response()->json(['error' => 'Invalid or unapproved appointment'], 400);
        }

        // Start tracking the visitor
        try {
            $trackingResponse = $this->visitController->trackVisit(
                $appointment->user_id,
                $request->input('latitude'),
                $request->input('longitude'),
                'enter'
            );

            return response()->json([
                'message' => 'QR code verified and tracking started',
                'tracking_data' => $trackingResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to start tracking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function stopTracking(Request $request)
    {
        try {
            $trackingResponse = $this->visitController->trackVisit(
                $request->user()->id,
                $request->input('latitude'),
                $request->input('longitude'),
                'exit'
            );

            return response()->json([
                'message' => 'Tracking stopped successfully',
                'tracking_data' => $trackingResponse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to stop tracking: ' . $e->getMessage()
            ], 500);
        }
    }
}