<?php

namespace App\Livewire;

use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\Building;
use App\Services\OcrService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class CounterBooking extends Component
{
    use WithFileUploads;

    // Guest Details
    public $first_name = '';
    public $last_name = '';
    public $mobile_number = '';
    public $id_type = 'aadhaar';
    public $id_number = '';
    public $address = '';
    public $id_image;
    public $ocr_processing = false;
    public $ocr_data = [];

    public $check_in;
    public $check_out;
    public $adults_male = 1;
    public $adults_female = 0;
    public $children = 0;
    public $selected_rooms = [];
    public $payment_mode = 'cash';
    public $filter_category_id = null;
    public $discount = 0;
    public $discount_reason = '';
    public $selectedBuildingId;

    // For View
    public $buildings = [];
    public $room_categories = [];

    public function mount()
    {
        $this->check_in = now()->format('Y-m-d\TH:i');
        $this->check_out = now()->addDay()->format('Y-m-d\TH:i');
        $this->room_categories = RoomCategory::all();
        $this->loadRooms();

        if ($this->buildings->count() > 0) {
            $this->selectedBuildingId = $this->buildings->first()->id;
        }
    }

    public function loadRooms()
    {
        $this->buildings = Building::with([
            'floors' => function ($query) {
                $query->orderBy('floor_number', 'desc');
            },
            'floors.rooms' => function ($query) {
                $query->with('roomCategory');
                if ($this->filter_category_id) {
                    $query->where('room_category_id', $this->filter_category_id);
                }
            }
        ])->get();
    }

    public function setFilter($categoryId = null)
    {
        $this->filter_category_id = $categoryId;
        $this->loadRooms();
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
            $this->selected_rooms[] = $roomId;
        }
    }

    public function updatedIdImage()
    {
        if ($this->id_image) {
            $this->processOcr();
        }
    }

    public function processOcr()
    {
        $this->ocr_processing = true;

        try {
            $tempPath = $this->id_image->getRealPath();
            $ocrService = new OcrService();

            if (!$ocrService->isAvailable()) {
                session()->flash('warning', 'OCR service not available. Please enter details manually.');
                $this->ocr_processing = false;
                return;
            }

            $this->ocr_data = $ocrService->extractAadhaarData($tempPath);

            if (!empty($this->ocr_data['name'])) {
                $nameParts = explode(' ', $this->ocr_data['name'], 2);
                $this->first_name = $nameParts[0] ?? '';
                $this->last_name = $nameParts[1] ?? '';
            }

            if (!empty($this->ocr_data['aadhaar_number'])) {
                $this->id_number = $this->ocr_data['aadhaar_number'];
            }

            if (!empty($this->ocr_data['address'])) {
                $this->address = $this->ocr_data['address'];
            }

            session()->flash('success', 'ID details extracted successfully!');
        } catch (\Exception $e) {
            \Log::error('OCR processing error: ' . $e->getMessage());
            session()->flash('warning', 'Could not extract ID details. Please enter manually.');
        }

        $this->ocr_processing = false;
    }

    #[Computed]
    public function selectedRoomsData()
    {
        return Room::with('roomCategory')->whereIn('id', $this->selected_rooms)->get();
    }

    #[Computed]
    public function totalDeposit()
    {
        return $this->selectedRoomsData()->sum(fn($room) => $room->roomCategory->deposit);
    }

    #[Computed]
    public function totalTariff()
    {
        return $this->selectedRoomsData()->sum(fn($room) => $room->roomCategory->base_tariff);
    }

    #[Computed]
    public function currentBuilding()
    {
        return Building::with(['floors.rooms.roomCategory', 'floors.rooms.activeBookings'])->find($this->selectedBuildingId);
    }

    #[Computed]
    public function buildingStats()
    {
        $building = $this->currentBuilding();
        if (!$building)
            return ['total' => 0, 'available' => 0, 'occupied' => 0, 'maintenance' => 0];

        $rooms = $building->floors->flatMap->rooms;

        return [
            'total' => $rooms->count(),
            'available' => $rooms->filter(fn($r) => $r->remaining_beds > 0 && $r->status !== 'maintenance')->count(),
            'occupied' => $rooms->filter(fn($r) => $r->remaining_beds <= 0 && $r->status !== 'maintenance')->count(),
            'maintenance' => $rooms->where('status', 'maintenance')->count(),
        ];
    }

    #[Computed]
    public function totalPayable()
    {
        return max(0, $this->totalTariff() + $this->totalDeposit() - (float) $this->discount);
    }

    #[Computed]
    public function selectedCapacity()
    {
        if (empty($this->selected_rooms))
            return 0;
        return Room::whereIn('id', $this->selected_rooms)->get()->sum('remaining_beds');
    }

    public function createBooking()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'id_type' => 'required|string',
            'id_number' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'selected_rooms' => 'required|array|min:1',
            'adults_male' => 'required|integer|min:0',
            'adults_female' => 'required|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'id_image' => 'nullable|image|max:2048',
            'payment_mode' => 'required|string',
            'discount' => 'nullable|numeric|min:0',
            'discount_reason' => 'nullable|string|max:255',
        ]);

        // Verify total capacity
        $totalAdults = $this->adults_male + $this->adults_female;
        if ($totalAdults < 1) {
            $this->addError('adults_male', "At least one adult is required.");
            return;
        }

        if ($this->selectedCapacity < $totalAdults) {
            $this->addError('selected_rooms', "Total capacity ({$this->selectedCapacity}) is less than adults ({$totalAdults}).");
            return;
        }

        $idImagePath = null;
        if ($this->id_image) {
            $idImagePath = $this->id_image->store('id_images', 'public');
        }

        $guest = Guest::firstOrCreate(
            ['mobile_number' => $this->mobile_number],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'address' => $this->address,
                'id_image_path' => $idImagePath
            ]
        );

        $booking = Booking::create([
            'guest_id' => $guest->id,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'total_amount' => $this->totalTariff() + $this->totalDeposit(),
            'discount_amount' => $this->discount,
            'discount_reason' => $this->discount_reason,
            'paid_amount' => $this->totalPayable(), // At counter, usually paid immediately
            'payment_mode' => $this->payment_mode,
            'status' => 'confirmed'
        ]);

        // Create initial payment recorded in reports
        if ($this->totalPayable() > 0) {
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $this->totalPayable(),
                'payment_mode' => $this->payment_mode,
                'status' => 'completed'
            ]);
        }

        $remainingMale = $this->adults_male;
        $remainingFemale = $this->adults_female;
        $remainingChildren = $this->children;
        $rooms = $this->selectedRoomsData;

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
                'tariff' => $room->roomCategory->base_tariff,
                'deposit' => $room->roomCategory->deposit,
                'adults' => $maleInThisRoom + $femaleInThisRoom,
                'adults_male' => $maleInThisRoom,
                'adults_female' => $femaleInThisRoom,
                'children' => $childrenInThisRoom
            ]);
        }

        session()->flash('success', 'Booking created successfully! Booking ID: ' . $booking->id);

        $this->reset(['first_name', 'last_name', 'mobile_number', 'id_number', 'address', 'selected_rooms', 'id_image', 'payment_mode', 'adults_male', 'adults_female', 'children', 'discount', 'discount_reason']);
        $this->adults_male = 1;
        $this->adults_female = 0;
        $this->children = 0;
        $this->loadRooms();
    }

    public function resetForm()
    {
        $this->reset(['first_name', 'last_name', 'mobile_number', 'id_number', 'address', 'selected_rooms', 'id_image', 'adults_male', 'adults_female', 'children', 'payment_mode', 'filter_category_id', 'discount', 'discount_reason']);
        $this->adults_male = 1;
        $this->adults_female = 0;
        $this->children = 0;
        $this->loadRooms();
        session()->flash('success', 'Form reset successfully!');
    }

    public function render()
    {
        return view('livewire.counter-booking');
    }
}
