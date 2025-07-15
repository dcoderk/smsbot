<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
           UserSeeder::class,  
           CommandSeeder::class,
        ]);

        // 1. Create one company to assign everyone to
        $company = Company::factory()->create([
            'company_name' => 'City General Hospital'
        ]);

        // 2. Create 3 staff members for that company
        User::factory()->count(3)->staff()->create([
            'company_id' => $company->id
        ]);

        // 3. Create 2 managers for that company
        User::factory()->count(2)->manager()->create([
            'company_id' => $company->id
        ]);
    }
}
