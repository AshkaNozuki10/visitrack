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
        $faker = Faker::create();
        $admin = User::updateOrCreate(
            ['last_name' => 'Alcantara'],   
            [
                'first_name' => 'Kyline',
                'middle_name' => 'Esperanza',
                'sex' => 'female',
                'birthdate' => $faker->date('Y-m-d', '2005-01-01'), // random date up to 2005-01-01
                'role' => 'admin',
            ]
        );

        Credential::updateOrCreate(
            ['username' => 'admin@example.com'],
            [
                'username' => 'admin@example.com',
                'password' => Hash::make('password123'), // Change to a secure password
            ]
        );

        Address::updateOrCreate(
            ['street_no' => '20'],
            [
                'street_name' => 'Dahlia Avenue',
                'barangay' => 'West Fairview',
                'district' => 'Novaliches',
                'city' => 'Quezon City'

            ]
        );
    }
}
