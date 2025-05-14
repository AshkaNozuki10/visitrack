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

<<<<<<< HEAD
    public function showAppointmentForm(){
        return view('appointments.form');
    }

=======
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
    public function approve(Appointment $appointment)
    {
        // Update appointment status to approved
        $appointment->update([
<<<<<<< HEAD
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
=======
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
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
    }

    // Method to store appointments
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
<<<<<<< HEAD
            'type' => 'required|in:Walk In,Appointment',
            'transaction_type' => 'required|string',
            'purpose' => 'required|string',
            'department' => 'required|in:CCS Department,
                                        Education Department,
                                        Accounting Department,
                                        Entrepreneurship Department,
                                        Engineering Department',
            'building' => 'required|in:Gymnasium,
                                    Administration Building,
                                    QCU Urban Farm Zone,
                                    Korphil Building,
                                    CHED Building,
                                    QCU Entrep Zone,
                                    Belmonte Building,
                                    New Academic Building,
                                    Quarantine Zone,
                                    Auditorium Building',
=======
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
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
<<<<<<< HEAD
            $appointment->type = $request->type;
            $appointment->transaction_type = $request->transaction_type;
=======
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
            $appointment->appointment_type = $request->appointment_type;
            $appointment->entity = $request->entity;
            $appointment->purpose = $request->purpose;
            $appointment->department = $request->department;
            $appointment->building = $request->building;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->approval = null; // Will be set when approved/rejected
            $appointment->save();
            
<<<<<<< HEAD
            DB::commit();
            
            return redirect()->route('show.pending.appointments')
=======
            // Generate QR code for all new appointments (except rejected)
            try {
                app(\App\Http\Controllers\GenerateQr::class)->generateForAppointment($appointment);
            } catch (\Exception $e) {
                // Optionally log or handle the error
            }
            
            DB::commit();
            
            return redirect()->route('appointments.pending')
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
                ->with('success', 'Appointment scheduled successfully! Your request is pending approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()->with('error', 'There was an error scheduling your appointment: ' . $e->getMessage());
        }
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
    }

    // Get pending appointments
    public function showPendingAppointments()
    {
<<<<<<< HEAD
=======
        $this->backfillMissingQRCodes();
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
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

<<<<<<< HEAD
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
=======
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
    public function show(Appointment $appointment)
    {
        // Ensure the user can only view their own appointments
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

<<<<<<< HEAD
        return view('appointments.form', compact('appointment'));
=======
        return view('appointments.show', compact('appointment'));
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
    }

    public function reject(Appointment $appointment)
    {
        $appointment->update([
<<<<<<< HEAD
            'approval' => 0
        ]);
        return redirect()->back()->with('success', 'Appointment has been denied.');
    }
}
=======
            'approval' => 0,
            'qr_code' => null // Remove QR code link if rejected
        ]);
        return redirect()->back()->with('success', 'Appointment has been denied.');
    }
}
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
