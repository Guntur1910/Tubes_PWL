<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            User::create([
                'name' => 'Organizer 1',
                'email' => 'organizer@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'organizer',
            ]);
        }
    }
}
