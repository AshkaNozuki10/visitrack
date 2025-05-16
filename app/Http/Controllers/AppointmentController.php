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

    public function approve(Appointment $appointment)
    {
        // Update appointment status to approved
        $appointment->update([
            'approval' => 1
        ]);

        // Try to find an existing QR code for this appointment
        $existingQr = null;
        foreach (\App\Models\QrCode::all() as $qrCode) {
            $qrData = json_decode($qrCode->qr_text, true);
            if (isset($qrData['appointment_id']) && $qrData['appointment_id'] == $appointment->appointment_id) {
                $existingQr = $qrCode;
                break;
            }
        }

        if ($existingQr) {
            $appointment->qr_code = $existingQr->qr_id;
            $appointment->save();
        } elseif (!$appointment->qr_code) {
            // Generate QR code automatically if not already linked
            try {
                $qrCode = $this->qrGenerator->generateForAppointment($appointment);
            } catch (\Exception $e) {
                return back()->with('error', 'Appointment approved but QR code generation failed: ' . $e->getMessage());
            }
        }

        // Redirect back with a success message
        return back()->with('success', 'Appointment approved! The visitor can now see their QR code in their Approved Appointments.');
    }

    // Method to store appointments
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'appointment_type' => 'required',
            'entity' => 'required',
            'purpose' => 'required',
            'department' => 'required',
            'building' => 'required',
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
            $visit->exit_time = $request->appointment_time; // Set to entry_time initially
            $visit->location = 1; // Default to Administration Building (location_id 1)
            $visit->save();
            
            // Create the appointment with the placeholder visit_id
            $appointment = new Appointment();
            $appointment->user_id = Auth::id();
            $appointment->visit_id = $visit->visit_id;
            $appointment->appointment_type = $request->appointment_type;
            $appointment->entity = $request->entity;
            $appointment->purpose = $request->purpose;
            $appointment->department = $request->department;
            $appointment->building = $request->building;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->approval = null; // Will be set when approved/rejected
            $appointment->save();
            
            // Generate QR code for all new appointments (except rejected)
            try {
                app(\App\Http\Controllers\GenerateQr::class)->generateForAppointment($appointment);
            } catch (\Exception $e) {
                // Optionally log or handle the error
            }
            
            DB::commit();
            
            return redirect()->route('appointments.pending')
                ->with('success', 'Appointment scheduled successfully! Your request is pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()->with('error', 'There was an error scheduling your appointment: ' . $e->getMessage());
        }
    }

    // Auto-backfill QR codes for all pending and approved appointments without one
    private function backfillMissingQRCodes()
    {
        $appointments = Appointment::where(function($q) {
            $q->where('approval', 1)->orWhereNull('approval');
        })
        ->whereNull('qr_code')
        ->get();

        foreach ($appointments as $appointment) {
            try {
                app(\App\Http\Controllers\GenerateQr::class)->generateForAppointment($appointment);
            } catch (\Exception $e) {
                // Optionally log or handle the error
            }
        }
    }

    // Get approved appointments with their QR codes
    public function getApprovedAppointments()
    {
        $this->backfillMissingQRCodes();
        $appointments = Appointment::where('user_id', Auth::id())
            ->where('approval', 1)
            ->with(['visit.location', 'qrCode'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(12); // Use pagination for better UX

        return view('appointments.approved', compact('appointments'));
    }

    // Get pending appointments
    public function showPendingAppointments()
    {
        $this->backfillMissingQRCodes();
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereNull('approval')
            ->with('visit.location')
            ->orderBy('created_at', 'desc')
            ->paginate(12); // Use pagination for links()
            
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

    public function show(Appointment $appointment)
    {
        // Ensure the user can only view their own appointments
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('appointments.show', compact('appointment'));
    }

    public function reject(Appointment $appointment)
    {
        $appointment->update([
            'approval' => 0,
            'qr_code' => null // Remove QR code link if rejected
        ]);
        return redirect()->back()->with('success', 'Appointment has been denied.');
    }
}
