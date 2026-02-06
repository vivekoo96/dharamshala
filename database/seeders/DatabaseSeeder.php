<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@dharamshala.com'],
            [
                'name' => 'Super Admin',
                'mobile_number' => '9999999999',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@dharamshala.com'],
            [
                'name' => 'Reception Staff',
                'mobile_number' => '8888888888',
                'password' => bcrypt('password123'),
                'role' => 'staff',
            ]
        );

        $this->call([
            StaffSeeder::class,
            PropertySeeder::class,
            RoomSeeder::class,
        ]);
    }
}
