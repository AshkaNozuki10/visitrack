<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkQrCodesToAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrcodes:link-to-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Linking QR codes to approved appointments...');
    
        $appointments = \App\Models\Appointment::where('approval', 1)
            ->whereNull('qr_code')
            ->get();
    
        $qrGenerator = new \App\Http\Controllers\GenerateQr();
    
        foreach ($appointments as $appointment) {
            try {
                $qrCode = $qrGenerator->generateForAppointment($appointment);
                $this->info("Linked QR code {$qrCode->qr_id} to appointment {$appointment->appointment_id}");
            } catch (\Exception $e) {
                $this->error("Failed for appointment {$appointment->appointment_id}: " . $e->getMessage());
            }
        }
    
        $this->info('Done!');
    }
}
