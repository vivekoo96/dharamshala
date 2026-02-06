<?php

namespace App\Livewire;

use App\Models\RoomCategory;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Building;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class OnlineBooking extends Component
{
    public $step = 1; // 1: Dates, 2: Rooms, 3: Guest Info, 4: Confirmation

    // Step 1: Date Selection
    public $check_in;
    public $check_out;
    public $guests = 1;

    // Step 2: Room Selection
    public $available_categories = [];
    public $selected_category_id;
    public $selected_room_id;
    public $buildings = [];
    public $selectedBuildingId;

    // Step 3: Guest Information
    public $first_name = '';
    public $last_name = '';
    public $mobile_number = '';
    public $email = '';
    public $special_requests = '';

    // Booking Summary
    public $total_amount = 0;
    public $nights = 0;

    public function updatedCheckIn($value)
    {
        if ($value) {
            $this->check_out = Carbon::parse($value)->addDay()->format('Y-m-d\TH:i');
            $this->nights = 1;
        }
    }

    public function mount()
    {
        $this->check_in = now()->addDay()->setHour(12)->setMinute(0)->format('Y-m-d\TH:i');
        $this->check_out = Carbon::parse($this->check_in)->addDay()->format('Y-m-d\TH:i');
    }

    public function searchRooms()
    {
        $this->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'guests' => 'required|integer|min:1'
        ]);

        $this->nights = Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));

        // Get available room categories
        $this->available_categories = RoomCategory::whereHas('rooms', function ($query) {
            $query->where('status', 'available');
        })
            ->with([
                'rooms' => function ($query) {
                    $query->where('status', 'available');
                }
            ])
            ->where('capacity', '>=', $this->guests)
            ->get();

        // Load buildings for the Room Map view
        $this->buildings = Building::with([
            'floors.rooms' => function ($query) {
                $query->with('roomCategory');
            }
        ])->get();

        if (!$this->selectedBuildingId && $this->buildings->count() > 0) {
            $this->selectedBuildingId = $this->buildings->first()->id;
        }

        $this->step = 2;
    }

    public function selectBuilding($buildingId)
    {
        $this->selectedBuildingId = $buildingId;
    }

    public function selectRoom($categoryId, $roomId)
    {
        $this->selected_category_id = $categoryId;
        $this->selected_room_id = $roomId;

        $category = RoomCategory::find($categoryId);
        $this->total_amount = $category->base_tariff * $this->nights;

        $this->step = 3;
    }

    public function confirmBooking()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'email' => 'nullable|email'
        ]);

        // Create or find guest
        $guest = Guest::firstOrCreate(
            ['mobile_number' => $this->mobile_number],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name
            ]
        );

        // Create booking
        $booking = Booking::create([
            'guest_id' => $guest->id,
            'check_in' => Carbon::parse($this->check_in)->format('Y-m-d H:i:s'),
            'check_out' => Carbon::parse($this->check_out)->format('Y-m-d H:i:s'),
            'total_amount' => $this->total_amount,
            'paid_amount' => 0,
            'status' => 'confirmed',
            'payment_mode' => 'online'
        ]);

        // Attach room with category tariff and deposit
        $category = RoomCategory::find($this->selected_category_id);
        $booking->rooms()->attach($this->selected_room_id, [
            'tariff' => $category->base_tariff,
            'deposit' => $category->deposit
        ]);

        // Update room status
        Room::where('id', $this->selected_room_id)->update(['status' => 'occupied']);

        $this->step = 4;
    }

    public function render()
    {
        return view('livewire.online-booking');
    }
}
