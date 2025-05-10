<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        $buildings = [
            'Gymnasium',
            'Administration Building',
            'QCU Urban Farm Zone',
            'Korphil Building',
            'CHED Building',
            'QCU Entrep Zone',
            'Belmonte Building',
            'Academic Building',
            'Quarantine Zone',
            'Auditorium Building'
        ];

        $departments = [
            'Admissions',
            'Registrar',
            'Accounting',
            'Student Affairs',
            'Academic Affairs'
        ];

        $entities = [
            'Student Services',
            'Faculty Department',
            'Administration Office',
            'Research Center',
            'Library Services'
        ];

        $purposes = [
            'Document Request',
            'Application Submission',
            'Meeting',
            'Consultation',
            'Payment'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $type = rand(0, 1) ? 'appointment' : 'walk_in';
            $date = $type === 'appointment' ? Carbon::now()->addDays(rand(1, 30))->format('Y-m-d') : null;
            $time = $type === 'appointment' ? Carbon::createFromTime(rand(8, 16), rand(0, 1) ? 0 : 30)->format('H:i:s') : null;
            
            DB::table('appointments')->insert([
                'user_id' => rand(1, 10), // Assuming you have users seeded
                'transaction_type' => $type,
                'entity' => $entities[array_rand($entities)],
                'purpose' => $purposes[array_rand($purposes)],
                'department' => $departments[array_rand($departments)],
                'building' => $buildings[array_rand($buildings)],
                'appointment_date' => $date,
                'appointment_time' => $time,
                'status' => rand(0, 1) ? 'approved' : 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
