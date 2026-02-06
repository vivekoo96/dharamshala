<?php

namespace App\Livewire;

use App\Models\Guest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCategory;
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
    public $number_of_guests = 1;
    public $selected_rooms = [];
    public $payment_mode = 'cash';
    public $filter_category_id = null;

    // Data for View
    public $available_rooms = [];
    public $room_categories = [];

    public function mount()
    {
        $this->check_in = now()->format('Y-m-d\TH:i');
        $this->check_out = now()->addDay()->format('Y-m-d\TH:i');
        $this->room_categories = RoomCategory::all();
        $this->loadAvailableRooms();
    }

    public function loadAvailableRooms()
    {
        $query = Room::with('roomCategory')
            ->where('status', 'available');

        if ($this->filter_category_id) {
            $query->where('room_category_id', $this->filter_category_id);
        }

        $this->available_rooms = $query->get();
    }

    public function setFilter($categoryId = null)
    {
        $this->filter_category_id = $categoryId;
        $this->loadAvailableRooms();
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
    public function totalPayable()
    {
        return $this->totalTariff() + $this->totalDeposit();
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
            'id_image' => 'nullable|image|max:2048',
            'payment_mode' => 'required|string'
        ]);

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
            'total_amount' => $this->totalPayable(),
            'paid_amount' => $this->totalPayable(), // At counter, usually paid immediately
            'payment_mode' => $this->payment_mode,
            'status' => 'confirmed'
        ]);

        foreach ($this->selectedRoomsData as $room) {
            $booking->rooms()->attach($room->id, [
                'tariff' => $room->roomCategory->base_tariff,
                'deposit' => $room->roomCategory->deposit
            ]);

            // Re-fetch to ensure it's a model instance and avoid lint warning
            Room::where('id', $room->id)->update(['status' => 'occupied']);
        }

        session()->flash('success', 'Booking created successfully! Booking ID: ' . $booking->id);

        $this->reset(['first_name', 'last_name', 'mobile_number', 'id_number', 'address', 'selected_rooms', 'id_image', 'payment_mode']);
        $this->loadAvailableRooms();
    }

    public function resetForm()
    {
        $this->reset(['first_name', 'last_name', 'mobile_number', 'id_number', 'address', 'selected_rooms', 'id_image', 'number_of_guests', 'payment_mode', 'filter_category_id']);
        $this->number_of_guests = 1;
        $this->loadAvailableRooms();
        session()->flash('success', 'Form reset successfully!');
    }

    public function render()
    {
        return view('livewire.counter-booking');
    }
}
