<?php

namespace App\Services;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    /**
     * Generate PDF invoice for a booking
     */
    public function generateInvoice(Booking $booking): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'booking' => $booking->load(['guest', 'rooms.roomCategory', 'payments']),
            'invoice_number' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => now()->format('d/m/Y'),
            'total_paid' => $booking->payments->sum('amount'),
            'balance' => $booking->total_amount - $booking->paid_amount
        ];

        return Pdf::loadView('invoices.booking', $data)
            ->setPaper('a4', 'portrait');
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice(Booking $booking): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generateInvoice($booking);
        $filename = 'invoice_' . $booking->id . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Stream invoice PDF (for preview)
     */
    public function streamInvoice(Booking $booking): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generateInvoice($booking);
        return $pdf->stream();
    }

    /**
     * Save invoice PDF to storage
     */
    public function saveInvoice(Booking $booking): string
    {
        $pdf = $this->generateInvoice($booking);
        $filename = 'invoices/invoice_' . $booking->id . '.pdf';

        \Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }
}
