<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CollectionReports extends Component
{
    public $report_type = 'daily'; // daily, shift, monthly
    public $date_from;
    public $date_to;
    public $shift = 'all'; // all, morning, evening, night

    public $summary = [];
    public $bookings_summary = [];

    public function mount()
    {
        $this->date_from = now()->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
        $this->loadReport();
    }

    public function loadReport()
    {
        $this->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $query = Payment::with('booking.guest')
            ->whereBetween('created_at', [
                Carbon::parse($this->date_from)->startOfDay(),
                Carbon::parse($this->date_to)->endOfDay()
            ]);

        // Shift filtering
        if ($this->shift !== 'all') {
            $query->where(function ($q) {
                $hours = match ($this->shift) {
                    'morning' => ['06:00:00', '14:00:00'],
                    'evening' => ['14:00:00', '22:00:00'],
                    'night' => ['22:00:00', '06:00:00'],
                };

                if ($this->shift === 'night') {
                    $q->whereTime('created_at', '>=', '22:00:00')
                        ->orWhereTime('created_at', '<', '06:00:00');
                } else {
                    $q->whereTime('created_at', '>=', $hours[0])
                        ->whereTime('created_at', '<', $hours[1]);
                }
            });
        }

        $payments = $query->get();

        // Bookings summary
        $bookingsQuery = Booking::whereBetween('created_at', [
            Carbon::parse($this->date_from)->startOfDay(),
            Carbon::parse($this->date_to)->endOfDay()
        ]);

        // Shift filtering for bookings as well
        if ($this->shift !== 'all') {
            $bookingsQuery->where(function ($q) {
                $hours = match ($this->shift) {
                    'morning' => ['06:00:00', '14:00:00'],
                    'evening' => ['14:00:00', '22:00:00'],
                    'night' => ['22:00:00', '06:00:00'],
                };

                if ($this->shift === 'night') {
                    $q->whereTime('created_at', '>=', '22:00:00')
                        ->orWhereTime('created_at', '<', '06:00:00');
                } else {
                    $q->whereTime('created_at', '>=', $hours[0])
                        ->whereTime('created_at', '<', $hours[1]);
                }
            });
        }

        $bookings = $bookingsQuery->get();

        // Payment summary
        $this->summary = [
            'total_collection' => $payments->sum('amount'),
            'total_transactions' => $payments->count(),
            'cash' => $payments->where('payment_mode', 'cash')->sum('amount'),
            'online' => $payments->where('payment_mode', 'online')->sum('amount'),
            'upi' => $payments->where('payment_mode', 'upi')->sum('amount'),
            'card' => $payments->where('payment_mode', 'card')->sum('amount'),
            'total_gross' => $bookings->sum('total_amount'),
            'total_discount' => $bookings->sum('discount_amount'),
        ];

        $this->bookings_summary = [
            'total_bookings' => $bookings->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'checked_in' => $bookings->where('status', 'checked_in')->count(),
            'checked_out' => $bookings->where('status', 'checked_out')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];
    }

    public function exportPDF()
    {
        $this->loadReport();

        $data = [
            'summary' => $this->summary,
            'bookings_summary' => $this->bookings_summary,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'shift' => $this->shift,
            'payments' => Payment::with('booking.guest')
                ->whereBetween('created_at', [
                    Carbon::parse($this->date_from)->startOfDay(),
                    Carbon::parse($this->date_to)->endOfDay()
                ])->get()
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.report-pdf', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'collection-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportCSV()
    {
        $this->loadReport();
        $payments = Payment::with('booking.guest')
            ->whereBetween('created_at', [
                Carbon::parse($this->date_from)->startOfDay(),
                Carbon::parse($this->date_to)->endOfDay()
            ])->get();

        $filename = "collection-report-" . now()->format('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Time', 'Guest Name', 'Mobile', 'Booking ID', 'Mode', 'Transaction ID', 'Amount']);

        foreach ($payments as $payment) {
            fputcsv($handle, [
                $payment->created_at->format('Y-m-d H:i:s'),
                $payment->booking->guest->first_name . ' ' . $payment->booking->guest->last_name,
                $payment->booking->guest->mobile_number,
                $payment->booking_id,
                strtoupper($payment->payment_mode),
                $payment->transaction_id,
                $payment->amount
            ]);
        }

        return response()->streamDownload(function () use ($handle) {
            fclose($handle);
        }, $filename);
    }

    public function updatedDateFrom()
    {
        $this->loadReport();
    }

    public function updatedDateTo()
    {
        $this->loadReport();
    }

    public function updatedShift()
    {
        $this->loadReport();
    }

    public function render()
    {
        return view('livewire.collection-reports');
    }
}
