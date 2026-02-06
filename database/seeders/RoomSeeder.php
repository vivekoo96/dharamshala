<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Floor;
use App\Models\RoomCategory;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Building
        $building = Building::firstOrCreate([
            'name' => 'Main Building',
            'location' => 'Main Campus',
            'address' => '123 Trust Way, Dharamshala',
        ]);

        // 2. Create Floors
        $floor1 = Floor::firstOrCreate(['building_id' => $building->id, 'floor_number' => '1']);
        $floor2 = Floor::firstOrCreate(['building_id' => $building->id, 'floor_number' => '2']);
        $floor3 = Floor::firstOrCreate(['building_id' => $building->id, 'floor_number' => '3']);

        // 3. Create Room Categories
        $standard = RoomCategory::create([
            'name' => 'Standard Room',
            'base_tariff' => 800.00,
            'deposit' => 500.00,
            'capacity' => 2,
            'features' => ['AC', 'TV', 'WiFi', 'Attached Bathroom'],
        ]);

        $deluxe = RoomCategory::create([
            'name' => 'Deluxe Room',
            'base_tariff' => 1200.00,
            'deposit' => 800.00,
            'capacity' => 3,
            'features' => ['AC', 'TV', 'WiFi', 'Mini Fridge', 'Balcony', 'Attached Bathroom'],
        ]);

        $suite = RoomCategory::create([
            'name' => 'Family Suite',
            'base_tariff' => 2000.00,
            'deposit' => 1200.00,
            'capacity' => 4,
            'features' => ['AC', 'TV', 'WiFi', 'Mini Fridge', 'Balcony', 'Living Area', 'Attached Bathroom'],
        ]);

        // 4. Create Rooms

        // Create Standard Rooms (101-110) on Floor 1
        for ($i = 101; $i <= 110; $i++) {
            Room::create([
                'room_number' => (string) $i,
                'room_category_id' => $standard->id,
                'floor_id' => $floor1->id,
                'status' => 'available',
            ]);
        }

        // Create Deluxe Rooms (201-208) on Floor 2
        for ($i = 201; $i <= 208; $i++) {
            Room::create([
                'room_number' => (string) $i,
                'room_category_id' => $deluxe->id,
                'floor_id' => $floor2->id,
                'status' => 'available',
            ]);
        }

        // Create Family Suites (301-305) on Floor 3
        for ($i = 301; $i <= 305; $i++) {
            Room::create([
                'room_number' => (string) $i,
                'room_category_id' => $suite->id,
                'floor_id' => $floor3->id,
                'status' => 'available',
            ]);
        }

        $this->command->info('✅ Created Building: ' . $building->name);
        $this->command->info('✅ Created 3 Floors');
        $this->command->info('✅ Created 3 Room Categories');
        $this->command->info('✅ Created 23 Rooms across 3 floors');
        $this->command->info('🎉 Seeding completed successfully!');
    }
}
