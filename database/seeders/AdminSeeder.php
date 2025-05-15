<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Credential;
use App\Models\User;
use App\Models\Address;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'last_name' => 'Alcantara',
            'first_name' => 'Ningning',
            'middle_name' => 'Esperanza',
            'sex' => 'female',
            'birthdate' => '2000-01-01',
            'role' => 'admin',
        ]);

        Credential::create([
            'user_id' => $user->user_id,
            'username' => 'admin@test.com',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
        ]);

        Address::create([
            'user_id' => $user->user_id,
            'street_no' => '19',
            'street_name' => 'Tomas Morato Avenue',
            'barangay' => 'South Triangle',
            'district' => 'Diliman',
            'city' => 'Quezon City',
        ]);
    }
}
