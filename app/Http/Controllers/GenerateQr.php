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
        // Only block rejected appointments
        if ($appointment->approval === 0) {
            throw new \Exception('Cannot generate QR code for rejected appointment');
        }

        // Generate unique content for the QR code
        $qrContent = $this->generateQrContent($appointment);

        // Generate QR code image
        $qrImage = QrCodeGenerator::format('png')
            ->size(300)
            ->generate($qrContent);

        // Store the QR code image in the public disk
        $fileName = uniqid() . '.png';
        $storagePath = 'qr_codes/' . $fileName;
        \Storage::disk('public')->put($storagePath, $qrImage);

        // Save the path as 'storage/qr_codes/filename.png' for web access
        $webPath = 'storage/' . $storagePath;

        // Create QR code record in database
        $qrCode = QrCode::create([
            'user_id' => $appointment->user_id,
            'qr_text' => $qrContent,
            'qr_picture' => $webPath,
            // Consider adding appointment_id if you add that field
        ]);

        // Update the appointment to reference the QR code
        $appointment->qr_code = $qrCode->qr_id;
        $appointment->save();

        return $qrCode;
    }

    protected function generateQrContent(Appointment $appointment)
    {
        // Get the visitor's name
        $visitorName = $appointment->user && $appointment->user->first_name ? $appointment->user->first_name : 'Unknown';
        return json_encode([
            'appointment_id' => $appointment->appointment_id,
            'user_id' => $appointment->user_id,
            'visitor_name' => $visitorName,
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
