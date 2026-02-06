<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'mobile_number' => '9999999999',
            'role' => 'admin',
            'password' => bcrypt('password123')
        ]);

        User::create([
            'name' => 'Counter Staff',
            'mobile_number' => '8888888888',
            'role' => 'staff',
            'password' => bcrypt('password123')
        ]);
    }
}
