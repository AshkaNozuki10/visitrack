<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Http\Controllers\GenerateQr;

class LinkExistingQrCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:link-existing-qr-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and link QR codes for all approved appointments without a QR code.';

    /**
     * Execute the console command.
     */
    public function handle()
{
        $this->info('Linking existing QR codes to approved appointments...');

        $appointments = \App\Models\Appointment::where('approval', 1)
            ->whereNull('qr_code')
            ->get();

    $qrCodes = \App\Models\QrCode::all();

        $linked = 0;
        foreach ($appointments as $appointment) {
    foreach ($qrCodes as $qrCode) {
                $qrData = json_decode($qrCode->qr_text, true);
                if (isset($qrData['appointment_id']) && $qrData['appointment_id'] == $appointment->appointment_id) {
                $appointment->qr_code = $qrCode->qr_id;
                $appointment->save();
                $this->info("Linked QR code {$qrCode->qr_id} to appointment {$appointment->appointment_id}");
                    $linked++;
                    break;
                }
            }
        }
        $this->info("Done! Linked $linked appointments.");
}
}
