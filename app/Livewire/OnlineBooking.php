<?php

namespace App\Livewire;

use App\Models\RoomCategory;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Building;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class OnlineBooking extends Component
{
    // Date Selection
    public $check_in;
    public $check_out;
    public $adults_male = 1;
    public $adults_female = 0;
    public $children = 0;

    // Room Selection
    public $available_categories = [];
    public $selected_category_id;
    public $selected_rooms = []; // Array of room IDs
    public $buildings = [];
    public $selectedBuildingId;

    // Guest Information
    public $first_name = '';
    public $last_name = '';
    public $mobile_number = '';
    public $email = '';
    public $id_type = 'Aadhar Card';
    public $id_number = '';
    public $city = '';
    public $special_requests = '';

    // Payment
    public $payment_mode = 'cash';
    public $deposit = 500;

    // Booking Summary
    public $total_amount = 0;
    public $nights = 1;
    public $booking_confirmed = false;

    public function updatedCheckIn($value)
    {
        if ($value) {
            $this->check_out = Carbon::parse($value)->addDay()->format('Y-m-d\TH:i');
            $this->calculateNights();
        }
    }

    public function updatedCheckOut($value)
    {
        $this->calculateNights();
    }

    public function calculateNights()
    {
        if ($this->check_in && $this->check_out) {
            $this->nights = max(1, Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out)));
            $this->updateTotalAmount();
        }
    }

    public function mount()
    {
        $this->check_in = now()->addDay()->setHour(12)->setMinute(0)->format('Y-m-d\TH:i');
        $this->check_out = Carbon::parse($this->check_in)->addDay()->format('Y-m-d\TH:i');

        // Load all data immediately for single-page view
        $this->loadRooms();
    }

    public function loadRooms()
    {
        // Load buildings for the Room Map view
        $this->buildings = Building::with([
            'floors' => function ($query) {
                $query->orderBy('floor_number', 'desc');
            },
            'floors.rooms' => function ($query) {
                $query->with('roomCategory');
            }
        ])->get();

        if (!$this->selectedBuildingId && $this->buildings->count() > 0) {
            $this->selectedBuildingId = $this->buildings->first()->id;
        }
    }

    public function selectBuilding($buildingId)
    {
        $this->selectedBuildingId = $buildingId;
    }

    public function toggleRoom($roomId)
    {
        if (in_array($roomId, $this->selected_rooms)) {
            $this->selected_rooms = array_diff($this->selected_rooms, [$roomId]);
        } else {
            $room = Room::find($roomId);
            if ($room && $room->remaining_beds > 0) {
                // Determine if we should allow selecting this room
                // For now, we allow any room with space to be selected
                $this->selected_rooms[] = $roomId;
                $this->selected_category_id = $room->room_category_id;
            }
        }
        $this->updateTotalAmount();
    }

    public function getSelectedCapacityProperty()
    {
        if (empty($this->selected_rooms))
            return 0;
        return Room::whereIn('id', $this->selected_rooms)->get()->sum('remaining_beds');
    }

    public function updateTotalAmount()
    {
        if ($this->selected_category_id) {
            $category = RoomCategory::find($this->selected_category_id);
            if ($category) {
                $this->total_amount = ($category->base_tariff * $this->nights) + $this->deposit;
            }
        }
    }

    public function setPaymentMode($mode)
    {
        $this->payment_mode = $mode;
    }

    public function confirmBooking()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'email' => 'nullable|email',
            'selected_rooms' => 'required|array|min:1',
            'adults_male' => 'required|integer|min:0',
            'adults_female' => 'required|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in'
        ]);

        // Verify total capacity
        $totalAdults = $this->adults_male + $this->adults_female;
        if ($totalAdults < 1) {
            $this->addError('adults_male', "At least one adult is required.");
            return;
        }

        if ($this->selected_capacity < $totalAdults) {
            $this->addError('selected_rooms', "Please select more rooms. Your group needs space for {$totalAdults} adults.");
            return;
        }

        // Create or find guest
        $guest = Guest::firstOrCreate(
            ['mobile_number' => $this->mobile_number],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email
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
            'payment_mode' => $this->payment_mode
        ]);

        // Attach rooms and distribute guests
        $category = RoomCategory::find($this->selected_category_id);
        $remainingMale = $this->adults_male;
        $remainingFemale = $this->adults_female;
        $remainingChildren = $this->children;

        $rooms = Room::whereIn('id', $this->selected_rooms)->get();

        foreach ($rooms as $room) {
            $capacity = $room->remaining_beds;

            // Distribute male adults first
            $maleInThisRoom = min($remainingMale, $capacity);
            $remainingMale -= $maleInThisRoom;
            $currentRoomBedsTaken = $maleInThisRoom;

            // Then female adults
            $femaleInThisRoom = min($remainingFemale, $capacity - $currentRoomBedsTaken);
            $remainingFemale -= $femaleInThisRoom;

            // Distribute children
            $childrenInThisRoom = 0;
            if ($remainingChildren > 0) {
                $childrenInThisRoom = count($rooms) > 1 ? ceil($this->children / count($rooms)) : $this->children;
                if ($childrenInThisRoom > $remainingChildren)
                    $childrenInThisRoom = $remainingChildren;
                $remainingChildren -= $childrenInThisRoom;
            }

            $booking->rooms()->attach($room->id, [
                'tariff' => $category->base_tariff,
                'deposit' => $this->deposit,
                'adults' => $maleInThisRoom + $femaleInThisRoom,
                'adults_male' => $maleInThisRoom,
                'adults_female' => $femaleInThisRoom,
                'children' => $childrenInThisRoom
            ]);
        }

        $this->booking_confirmed = true;

        // Reset form
        $this->reset(['first_name', 'last_name', 'mobile_number', 'email', 'selected_rooms', 'selected_category_id', 'special_requests', 'adults_male', 'adults_female', 'children']);
        $this->adults_male = 1;
        $this->adults_female = 0;
        $this->children = 0;
        $this->loadRooms();
    }

    public function resetForm()
    {
        $this->reset();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.online-booking');
    }
}
