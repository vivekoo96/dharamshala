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
    // Date Selection
    public $check_in;
    public $check_out;
    public $guests = 1;

    // Room Selection
    public $available_categories = [];
    public $selected_category_id;
    public $selected_room_id;
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

    public function selectRoom($categoryId, $roomId)
    {
        $this->selected_category_id = $categoryId;
        $this->selected_room_id = $roomId;
        $this->updateTotalAmount();
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
            'selected_room_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in'
        ]);

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

        // Attach room with category tariff and deposit
        $category = RoomCategory::find($this->selected_category_id);
        $booking->rooms()->attach($this->selected_room_id, [
            'tariff' => $category->base_tariff,
            'deposit' => $this->deposit
        ]);

        // Update room status
        Room::where('id', $this->selected_room_id)->update(['status' => 'occupied']);

        $this->booking_confirmed = true;

        // Reset form
        $this->reset(['first_name', 'last_name', 'mobile_number', 'email', 'selected_room_id', 'selected_category_id', 'special_requests']);
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
