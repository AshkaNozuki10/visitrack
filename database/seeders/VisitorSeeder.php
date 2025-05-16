<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\Credential;
use Illuminate\Support\Facades\Hash;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'last_name' => 'Espana',
            'first_name' => 'Carla',
            'middle_name' => 'Aurora',
            'sex' => 'female',
            'birthdate' => '2001-01-01',
            'role' => 'visitor',
        ]);

        Credential::create([
            'user_id' => $user->user_id,
            'username' => 'visitor@test.com',
            'email' => 'visitor@test.com',
            'password' => Hash::make('12345678'),
        ]);

        Address::create([
            'user_id' => $user->user_id,
            'street_no' => '55',
            'street_name' => 'Carlos P. Garcia Avenue',
            'barangay' => 'UP Village',
            'district' => 'Diliman',
            'city' => 'Quezon City',
        ]);
    }
}
