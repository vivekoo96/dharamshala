<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CashLedger extends Component
{
    public $date_filter;
    public $payment_mode_filter = 'all';
    public $payments = [];
    public $summary = [];

    public function mount()
    {
        $this->date_filter = now()->format('Y-m-d');
        $this->loadPayments();
    }

    public function loadPayments()
    {
        $query = Payment::with('booking.guest')
            ->whereDate('created_at', $this->date_filter);

        if ($this->payment_mode_filter !== 'all') {
            $query->where('payment_mode', $this->payment_mode_filter);
        }

        $this->payments = $query->orderBy('created_at', 'desc')->get();

        // Calculate summary
        $this->summary = [
            'total' => $this->payments->sum('amount'),
            'count' => $this->payments->count(),
            'cash' => $this->payments->where('payment_mode', 'cash')->sum('amount'),
            'online' => $this->payments->where('payment_mode', 'online')->sum('amount'),
            'upi' => $this->payments->where('payment_mode', 'upi')->sum('amount'),
            'card' => $this->payments->where('payment_mode', 'card')->sum('amount'),
        ];
    }

    public function updatedDateFilter()
    {
        $this->loadPayments();
    }

    public function updatedPaymentModeFilter()
    {
        $this->loadPayments();
    }

    public function render()
    {
        return view('livewire.cash-ledger');
    }
}
