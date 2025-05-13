<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\QrCode;
use App\Models\Visit;
use App\Http\Controllers\GenerateQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $qrGenerator;

    public function __construct(GenerateQr $qrGenerator)
    {
        $this->qrGenerator = $qrGenerator;
    }

    public function showAppointmentForm(){
        return view('appointments.form');
    }

    public function approve(Appointment $appointment)
    {
        // Update appointment status to approved
        $appointment->update([
            'approval' => 1,
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

    // Method to store appointments
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|in:Walk In,Appointment',
            'transaction_type' => 'required|string',
            'purpose' => 'required|string',
            'department' => 'required|in:CCS Department,Education Department,Accounting Department,Entrepreneurship Department,Engineering Department',
            'building' => 'required|in:Gymnasium,Administration Building,QCU Urban Farm Zone,Korphil Building,CHED Building,QCU Entrep Zone,Belmonte Building,New Academiz Building,Quarantine Zone,Auditorium Building',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Create a placeholder visit record since we need a visit_id for the appointment
            // Note: This visit record will be updated when the user actually visits
            $visit = new Visit();
            $visit->user_id = Auth::id();
            $visit->visit_date = $request->appointment_date;
            $visit->entry_time = $request->appointment_time;
            $visit->exit_time = null; // Will be filled when user leaves
            $visit->location = 1; // Default location, will be updated during actual visit
            $visit->save();
            
            // Create the appointment with the placeholder visit_id
            $appointment = new Appointment();
            $appointment->user_id = Auth::id();
            $appointment->visit_id = $visit->visit_id;
            $appointment->type = $request->type;
            $appointment->transaction_type = $request->transaction_type;
            $appointment->purpose = $request->purpose;
            $appointment->department = $request->department;
            $appointment->building = $request->building;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->approval = null; // Will be set when approved/rejected
            $appointment->save();
            
            DB::commit();
            
            return redirect()->route('show.pending.appointments')
                ->with('success', 'Appointment scheduled successfully! Your request is pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()->with('error', 'There was an error scheduling your appointment: ' . $e->getMessage());
        }
    }

    // Get approved appointments with their QR codes
    public function getApprovedAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('approval', 1)
            ->with(['visit.location'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
            
        return response()->json($appointments->map(function($appointment) {
            return [
                'id' => $appointment->appointment_id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'location_name' => $appointment->visit->location->building_name ?? 'Not specified',
                'qr_code_url' => $appointment->qrCode ? url('storage/qrcodes/' . $appointment->qrCode->qr_image) : null,
                'qr_code_id' => $appointment->qrCode ? $appointment->qrCode->qr_id : null
            ];
        }));
    }

    // Get pending appointments
    public function showPendingAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereNull('approval')
            ->with('visit.location')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('appointments.pending', compact('appointments'));
    }

    // Get rejected appointments
    public function showRejectedAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('approval', 0)
            ->with('visit.location')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('appointments.rejected', compact('appointments'));
    }

    // Get approved appointments
    public function showApprovedAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('approval', 1)
            ->with(['visit.location', 'qrCode'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
            
        return view('appointments.approved', compact('appointments'));
    }

    public function printAppointments(){
        // Get the user's approved appointments
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('approval', 1)
            ->with(['visit.location', 'qrCode'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
            
        // Return a printer-friendly view
        return view('appointments.print', compact('appointments'));
    }
}