<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Admin
        \App\Models\User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@jobtracker.com',
            'password' => bcrypt('Admin@123'),
            'role'     => 'admin',
        ]);

        // Demo User
        \App\Models\User::create([
            'name'     => 'Demo User',
            'email'    => 'user@jobtracker.com',
            'password' => bcrypt('User@123'),
            'role'     => 'user',
        ]);
    }
}
