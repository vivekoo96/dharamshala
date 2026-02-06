<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [
            [
                'name' => 'John Doe',
                'role' => 'Manager',
                'phone' => '9876543210',
                'email' => 'john@example.com',
                'qr_code' => 'STAFF-JOHN123',
                'status' => 'active',
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'Front Desk',
                'phone' => '9876543211',
                'email' => 'jane@example.com',
                'qr_code' => 'STAFF-JANE456',
                'status' => 'active',
            ],
            [
                'name' => 'Robert Wilson',
                'role' => 'Housekeeping',
                'phone' => '9876543212',
                'email' => 'robert@example.com',
                'qr_code' => 'STAFF-ROB789',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Brown',
                'role' => 'Housekeeping',
                'phone' => '9876543213',
                'email' => 'sarah@example.com',
                'qr_code' => 'STAFF-SARAH001',
                'status' => 'active',
            ],
            [
                'name' => 'Michael Davis',
                'role' => 'Security',
                'phone' => '9876543214',
                'email' => 'michael@example.com',
                'qr_code' => 'STAFF-MIKE002',
                'status' => 'inactive',
            ],
        ];

        foreach ($staff as $s) {
            Staff::create($s);
        }
    }
}
