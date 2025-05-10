<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\credential;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        credential::create([
            'user_id' => 1,
            'username' => 'johndoe',
            'password' => bcrypt('password123'), // Use bcrypt for hashing
        ]);
        
        credential::create([
            'user_id' => 2,
            'username' => 'janedoe',
            'password' => bcrypt('password456'), // Use bcrypt for hashing
        ]);
        
        credential::create([
            'user_id' => 3,
            'username' => 'admin',
            'password' => bcrypt('admin123'), // Use bcrypt for hashing
        ]);
    }
}
