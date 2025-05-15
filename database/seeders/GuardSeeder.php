<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use App\Models\Credential;

class GuardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'last_name' => 'Espalto',
            'first_name' => 'Darren',
            'middle_name' => 'Catalina',
            'sex' => 'male',
            'birthdate' => '1995-01-01',
            'role' => 'guard',
        ]);

        Credential::create([
            'user_id' => $user->user_id,
            'username' => 'guard@test.com',
            'email' => 'guard@test.com',
            'password' => Hash::make('12345678'),
        ]);

        Address::create([
            'user_id' => $user->user_id,
            'street_no' => '220',
            'street_name' => 'Quirino Highway',
            'barangay' => 'Tungkong Mangga',
            'district' => 'District 1',
            'city' => 'City of San Jose Del Monte',
        ]);
    }
}
