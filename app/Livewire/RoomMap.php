<?php

namespace App\Livewire;

use App\Models\Building;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class RoomMap extends Component
{
    public $buildings;
    public $selectedBuildingId;

    public function mount()
    {
        $this->buildings = Building::with(['floors.rooms.roomCategory'])->get();
        $this->selectedBuildingId = $this->buildings->first()?->id;
    }

    public function selectBuilding($buildingId)
    {
        $this->selectedBuildingId = $buildingId;
    }

    public function render()
    {
        return view('livewire.room-map', [
            'building' => Building::with(['floors.rooms.roomCategory'])->find($this->selectedBuildingId)
        ]);
    }
}
