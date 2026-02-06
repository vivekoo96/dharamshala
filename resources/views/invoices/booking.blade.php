<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .invoice-info {
            margin-bottom: 30px;
        }

        .invoice-info table {
            width: 100%;
        }

        .invoice-info td {
            padding: 5px 0;
        }

        .guest-info {
            background: #F3F4F6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .guest-info h3 {
            margin: 0 0 10px 0;
            color: #4F46E5;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table.items th {
            background: #4F46E5;
            color: white;
            padding: 12px;
            text-align: left;
        }

        table.items td {
            padding: 10px 12px;
            border-bottom: 1px solid #E5E7EB;
        }

        table.items tr:last-child td {
            border-bottom: none;
        }

        .totals {
            margin-top: 20px;
            text-align: right;
        }

        .totals table {
            margin-left: auto;
            width: 300px;
        }

        .totals td {
            padding: 8px;
        }

        .totals .grand-total {
            font-size: 18px;
            font-weight: bold;
            background: #F3F4F6;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #E5E7EB;
            padding-top: 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DHARAMSHALA CONNECT</h1>
        <p>Near Temple Entrance, Main Dham</p>
        <p>Phone: +91 XXXXX XXXXX | Email: info@dharamshalaconnect.com</p>
    </div>

    <div class="invoice-info">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>Invoice Number:</strong> {{ $invoice_number }}<br>
                    <strong>Invoice Date:</strong> {{ $invoice_date }}<br>
                    <strong>Booking ID:</strong> #{{ $booking->id }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Check-in:</strong>
                    {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, h:i A') }}<br>
                    <strong>Check-out:</strong>
                    {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, h:i A') }}<br>
                    <strong>Status:</strong> <span
                        class="badge badge-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">{{ strtoupper($booking->status) }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="guest-info">
        <h3>Guest Information</h3>
        <strong>Name:</strong> {{ $booking->guest->first_name }} {{ $booking->guest->last_name }}<br>
        <strong>Mobile:</strong> {{ $booking->guest->mobile_number }}<br>
        @if($booking->guest->address)
            <strong>Address:</strong> {{ $booking->guest->address }}
        @endif
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Room Details</th>
                <th>Category</th>
                <th>Nights</th>
                <th>Rate/Night</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->rooms as $room)
                @php
                    $nights = \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out));
                    $tariff = $room->pivot->tariff;
                    $amount = $tariff * $nights;
                @endphp
                <tr>
                    <td>Room {{ $room->room_number }}</td>
                    <td>{{ $room->roomCategory->name }}</td>
                    <td>{{ $nights }}</td>
                    <td>₹{{ number_format($tariff, 2) }}</td>
                    <td style="text-align: right;">₹{{ number_format($amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td style="text-align: right;">₹{{ number_format($booking->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Amount Paid:</strong></td>
                <td style="text-align: right; color: #10B981;">₹{{ number_format($total_paid, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td><strong>Balance Due:</strong></td>
                <td style="text-align: right; color: {{ $balance > 0 ? '#EF4444' : '#10B981' }};">
                    ₹{{ number_format($balance, 2) }}</td>
            </tr>
        </table>
    </div>

    @if($booking->payments->count() > 0)
        <div style="margin-top: 30px;">
            <h3 style="color: #4F46E5; margin-bottom: 10px;">Payment History</h3>
            <table class="items">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Mode</th>
                        <th>Transaction ID</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                            <td>{{ strtoupper($payment->payment_mode) }}</td>
                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                            <td style="text-align: right;">₹{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        <p><strong>Terms & Conditions:</strong></p>
        <p>1. Check-in time: 12:00 PM | Check-out time: 11:00 AM</p>
        <p>2. ID proof is mandatory at the time of check-in</p>
        <p>3. Cancellation charges apply as per policy</p>
        <p style="margin-top: 15px;">Thank you for choosing Dharamshala Connect!</p>
        <p>This is a computer-generated invoice and does not require a signature.</p>
    </div>
</body>

</html>