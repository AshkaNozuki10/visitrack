<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

class GenerateQr extends Controller
{
    public function generateForAppointment(Appointment $appointment){
        // Validate that the appointment is approved
        if (!$appointment->is_approved(['rejected'])) {
            throw new \Exception('Cannot generate QR code for unapproved appointment');
        }

        // Generate unique content for the QR code
        $qrContent = $this->generateQrContent($appointment);

        // Generate QR code image
        $qrImage = QrCodeGenerator::format('png')
            ->size(300)
            ->generate($qrContent);

        // Store the QR code image
        $storagePath = 'qr_codes/' . uniqid() . '.png';
        Storage::put($storagePath, $qrImage);

        // Create QR code record in database
        $qrCode = QrCode::create([
            'user_id' => $appointment->user_id,
            'qr_text' => $qrContent,
            'qr_picture' => $storagePath,
            // Consider adding appointment_id if you add that field
        ]);

        return $qrCode;
    }

    protected function generateQrContent(Appointment $appointment)
    {
        // You can customize this to include whatever information you need
        return json_encode([
            'appointment_id' => $appointment->appointment_id,
            'user_id' => $appointment->user_id,
            'verification_code' => bin2hex(random_bytes(8)),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Display the QR code for a user
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $qrCode = QrCode::where('user_id', $request->user()->id)
                        ->findOrFail($id);

        return response()->file(Storage::path($qrCode->qr_picture));
    }
}
