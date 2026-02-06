<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $b1 = \App\Models\Building::create(['name' => 'Main Dham', 'location' => 'East Wing', 'address' => 'Near Temple Entrance']);
        $b2 = \App\Models\Building::create(['name' => 'Shanti Dham', 'location' => 'West Wing', 'address' => 'Near Garden Area']);

        $c1 = \App\Models\RoomCategory::create(['name' => 'AC Double Room', 'base_tariff' => 1200, 'deposit' => 500, 'capacity' => 2, 'features' => ['AC', 'WiFi', 'Attached Bath']]);
        $c2 = \App\Models\RoomCategory::create(['name' => 'Non-AC Double Room', 'base_tariff' => 800, 'deposit' => 300, 'capacity' => 2, 'features' => ['WiFi', 'Attached Bath']]);
        $c3 = \App\Models\RoomCategory::create(['name' => 'Dormitory (AC)', 'base_tariff' => 300, 'deposit' => 100, 'capacity' => 10, 'features' => ['AC', 'Shared Bath']]);

        foreach ([$b1, $b2] as $building) {
            foreach (['Ground Floor', 'First Floor'] as $index => $floorName) {
                $floor = $building->floors()->create(['floor_number' => $floorName]);

                // Create some rooms for each floor
                for ($i = 1; $i <= 5; $i++) {
                    $cat = ($i % 3 == 0) ? $c3 : (($i % 2 == 0) ? $c2 : $c1);
                    $roomNum = (str_contains($floorName, 'Ground') ? 'G' : '1') . '0' . $i;
                    $floor->rooms()->create([
                        'room_category_id' => $cat->id,
                        'room_number' => $roomNum,
                        'status' => 'available'
                    ]);
                }
            }
        }
    }
}
