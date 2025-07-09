<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin user already exists to avoid duplicates
        if (!User::where('email', 'adfirm02k@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'adfirm02k@gmail.com',
                'password' => Hash::make('1234567#'), // Important: Change this!
                'role' => 'Super Admin',
                'company_id' => null, // Super Admin is not tied to a specific company
                'email_verified_at' => now(),
            ]);
        }
    }
}