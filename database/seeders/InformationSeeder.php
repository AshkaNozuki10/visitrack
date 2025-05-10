<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_id' => 1,
            'last_name' => 'Doe',
            'first_name' => 'John',
            'middle_name' => 'M',
            'sex' => 'male',
            'birthdate' => '1990-01-01',
            'role' => 'student',
        ]);
    }
}
