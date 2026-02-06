<?php

namespace App\Livewire\Operations;

use App\Models\Device; // Assuming room mapping? No, Room model.
use App\Models\MaintenanceRequest;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $showModal = false;
    public $requestId;

    // Form fields
    public $room_id;
    public $issue_description;
    public $priority = 'medium';
    public $status = 'pending';
    public $reported_by;

    protected $rules = [
        'room_id' => 'required|exists:rooms,id',
        'issue_description' => 'required|string|max:1000',
        'priority' => 'required|in:low,medium,high,critical',
        'status' => 'required|in:pending,in_progress,resolved',
    ];

    public function mount()
    {
        $this->reported_by = auth()->user()->name ?? 'System';
    }

    public function render()
    {
        $query = MaintenanceRequest::with('room')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('issue_description', 'like', '%' . $this->search . '%')
                ->orWhereHas('room', function ($q) {
                    $q->where('room_number', 'like', '%' . $this->search . '%');
                });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        $requests = $query->paginate(10);
        $rooms = Room::orderBy('room_number')->get(['id', 'room_number']);

        return view('livewire.operations.maintenance-manager', [
            'requests' => $requests,
            'rooms' => $rooms
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['room_id', 'issue_description', 'priority', 'status', 'requestId']);
        $this->status = 'pending'; // Default for new
        $this->showModal = true;
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        $this->requestId = $request->id;
        $this->room_id = $request->room_id;
        $this->issue_description = $request->issue_description;
        $this->priority = $request->priority;
        $this->status = $request->status;

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'room_id' => $this->room_id,
            'issue_description' => $this->issue_description,
            'priority' => $this->priority,
            'status' => $this->status,
            'reported_by' => $this->reported_by
        ];

        if ($this->status === 'resolved') {
            $data['resolved_at'] = now();
        }

        if ($this->requestId) {
            $request = MaintenanceRequest::findOrFail($this->requestId);
            $request->update($data);
            session()->flash('message', 'Maintenance request updated.');
        } else {
            MaintenanceRequest::create($data);
            session()->flash('message', 'Maintenance request logged.');
        }

        $this->showModal = false;
    }

    public function markResolved($id)
    {
        $request = MaintenanceRequest::findOrFail($id);
        $request->update([
            'status' => 'resolved',
            'resolved_at' => now()
        ]);
        session()->flash('message', 'Marked as resolved.');
    }

    public function delete($id)
    {
        MaintenanceRequest::findOrFail($id)->delete();
        session()->flash('message', 'Record deleted.');
    }
}
