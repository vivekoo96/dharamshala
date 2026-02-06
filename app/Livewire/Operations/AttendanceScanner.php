<?php

namespace App\Livewire\Operations;

use App\Models\Attendance;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceScanner extends Component
{
    public $qrCodeInput = '';
    public $manualStaffId = '';
    public $scanResult = null; // success, error
    public $message = '';
    public $selectedDate;

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function processScan()
    {
        // Simulate scanning by finding staff with matching QR code
        $qr = trim($this->qrCodeInput);
        if (empty($qr))
            return;

        $staff = Staff::where('qr_code', $qr)->first();

        if (!$staff) {
            $this->scanResult = 'error';
            $this->message = 'Invalid QR Code. Staff not found.';
            $this->qrCodeInput = '';
            return;
        }

        $this->handleCheckInCheckOut($staff);
        $this->qrCodeInput = '';
    }

    public function manualCheckIn()
    {
        if (!$this->manualStaffId)
            return;

        $staff = Staff::find($this->manualStaffId);
        if (!$staff)
            return;

        $this->handleCheckInCheckOut($staff);
        $this->manualStaffId = '';
    }

    private function handleCheckInCheckOut(Staff $staff)
    {
        if ($staff->status !== 'active') {
            $this->scanResult = 'error';
            $this->message = "Staff member {$staff->name} is inactive.";
            return;
        }

        $today = Carbon::today();

        // Find existing attendance for today
        $attendance = Attendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            // Check In
            Attendance::create([
                'staff_id' => $staff->id,
                'date' => $today,
                'check_in_time' => now(),
                'status' => 'present'
            ]);
            $this->scanResult = 'success';
            $this->message = "Check-in successful for {$staff->name} at " . now()->format('H:i');
        } elseif (!$attendance->check_out_time) {
            // Check Out
            $attendance->update([
                'check_out_time' => now()
            ]);
            $this->scanResult = 'success';
            $this->message = "Check-out successful for {$staff->name} at " . now()->format('H:i');
        } else {
            // Already checked out
            $this->scanResult = 'warning';
            $this->message = "{$staff->name} has already completed attendance for today.";
        }
    }

    public function render()
    {
        $recentActivity = Attendance::with('staff')
            ->where('date', Carbon::today())
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $activeStaff = Staff::where('status', 'active')->orderBy('name')->get();

        // Get daily stats
        $totalStaff = $activeStaff->count();
        $presentToday = Attendance::where('date', Carbon::today())->count();

        return view('livewire.operations.attendance-scanner', [
            'recentActivity' => $recentActivity,
            'allStaff' => $activeStaff,
            'stats' => [
                'total' => $totalStaff,
                'present' => $presentToday,
                'absent' => $totalStaff - $presentToday
            ]
        ]);
    }
}
