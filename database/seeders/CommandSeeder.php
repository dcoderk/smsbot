<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Command;

class CommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the main command
        $command = Command::create([
            'trigger' => 'Admission',
            'description' => 'Adminsion'
        ]);

        // 2. Create the two replies and associate them with the command
        $command->replies()->create([
            'type' => 'text',
            'content' => 'Thank Tony, LPN. see link to direct you what to do.'
        ]);

        $command->replies()->create([
            'type' => 'url',
            'content' => 'www.tony.com/as'
        ]);
    }
}
