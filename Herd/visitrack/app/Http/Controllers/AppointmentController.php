<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\QrCode;
use App\Http\Controllers\GenerateQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $qrGenerator;

    public function __construct(generateQr $qrGenerator)
    {
        $this->qrGenerator = $qrGenerator;
    }

    public function approve(appointment $appointment)
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

    // New method to store appointments
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'purpose' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,location_id',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Create the appointment
            $appointment = new Appointment();
            $appointment->visitor_id = Auth::id();
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->purpose = $request->purpose;
            $appointment->location_id = $request->location_id;
            $appointment->status = 'pending'; // Default status
            $appointment->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Appointment scheduled successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Get approved appointments with their QR codes
    public function getApprovedAppointments()
    {
        $appointments = appointment::where('visitor_id', auth()->appointment_id())
            ->where('status', 'approved')
            ->with(['location:location_id,name', 'qrCode'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
            
        return response()->json($appointments->map(function($appointment) {
            return [
                'id' => $appointment->id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'purpose' => $appointment->purpose,
                'location_name' => $appointment->location->name,
                'qr_code_url' => $appointment->qrCode ? url('storage/qrcodes/' . $appointment->qrCode->filename) : null,
                'qr_code_id' => $appointment->qrCode ? $appointment->qrCode->id : null
            ];
        }));
    }

    // Get pending appointments
    public function pending()
    {
        $appointments = appointment::where('visitor_id', auth()->id())
            ->where('status', 'pending')
            ->with('location:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('appointments.pending', compact('appointments'));
    }

    // Get rejected appointments
    public function rejected()
    {
        $appointments = appointment::where('visitor_id', auth()->id())
            ->where('status', 'rejected')
            ->with('location:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('appointments.rejected', compact('appointments'));
    }
}