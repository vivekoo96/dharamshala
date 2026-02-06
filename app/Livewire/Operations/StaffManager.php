<?php

namespace App\Livewire\Operations;

use App\Models\Staff;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class StaffManager extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $staffId;

    // Form fields
    public $name;
    public $role = 'staff';
    public $phone;
    public $email;
    public $status = 'active';

    protected $rules = [
        'name' => 'required|string|max:255',
        'role' => 'required|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'status' => 'required|in:active,inactive',
    ];

    public function render()
    {
        $staff = Staff::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.operations.staff-manager', [
            'staffMembers' => $staff
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'role', 'phone', 'email', 'status', 'staffId']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $staff = Staff::findOrFail($id);
        $this->staffId = $staff->id;
        $this->name = $staff->name;
        $this->role = $staff->role;
        $this->phone = $staff->phone;
        $this->email = $staff->email;
        $this->status = $staff->status;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'role' => $this->role,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
        ];

        if (!$this->isEditing) {
            // Generate unique QR code content for new staff
            $data['qr_code'] = 'STAFF-' . strtoupper(Str::random(8));
            Staff::create($data);
            session()->flash('message', 'Staff member added successfully.');
        } else {
            $staff = Staff::findOrFail($this->staffId);
            $staff->update($data);
            session()->flash('message', 'Staff member updated successfully.');
        }

        $this->showModal = false;
    }

    public function delete($id)
    {
        Staff::findOrFail($id)->delete();
        session()->flash('message', 'Staff member deleted successfully.');
    }

    public function generateNewQr($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->update([
            'qr_code' => 'STAFF-' . strtoupper(Str::random(8))
        ]);
        session()->flash('message', 'New QR code generated.');
    }
}
