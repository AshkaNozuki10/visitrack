<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        address::create([
            'user_id' => 1,
            'street_no' => '123',
            'street_name' => 'Corvette',
            'barangay' => 'West Fairview',
            'district' => 'District 5',
            'city' => 'Quezon City',
        ]);
    }
}
