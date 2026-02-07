<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ trans_db('collection_report') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #5b21b6;
            padding-bottom: 15px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #5b21b6;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .summary-box {
            margin-bottom: 30px;
        }

        .grid {
            width: 100%;
            margin-bottom: 20px;
        }

        .grid td {
            vertical-align: top;
            width: 50%;
        }

        .card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 8px;
        }

        .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .value {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.data-table th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
            font-size: 11px;
        }

        table.data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            padding: 10px 0;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">Shree Ram Trust Dharamshala</h1>
        <p class="subtitle">{{ trans_db('collection_report') }} ({{ $date_from }} to {{ $date_to }})</p>
        <p style="font-size: 11px;">{{ trans_db('shift') }}: {{ strtoupper($shift) }}</p>
    </div>

    <div class="summary-box">
        <table class="grid">
            <tr>
                <td style="width: 33.33%;">
                    <div class="card" style="background: #eef2ff;">
                        <div class="label">Gross Revenue</div>
                        <div class="value">₹{{ number_format($summary['total_gross'], 0) }}</div>
                    </div>
                </td>
                <td style="width: 33.33%;">
                    <div class="card" style="background: #fff7ed;">
                        <div class="label">Total Discounts</div>
                        <div class="value">₹{{ number_format($summary['total_discount'], 0) }}</div>
                    </div>
                </td>
                <td style="width: 33.33%;">
                    <div class="card" style="background: #ecfdf5;">
                        <div class="label">Net Collection</div>
                        <div class="value">₹{{ number_format($summary['total_collection'], 0) }}</div>
                        <div style="font-size: 10px; color: #666;">{{ $summary['total_transactions'] }} Transactions
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="grid" style="margin-top: -10px;">
            <tr>
                <td style="width: 25%;">
                    <div class="card">
                        <div class="label">{{ trans_db('cash') }}</div>
                        <div style="font-weight: bold;">₹{{ number_format($summary['cash'], 0) }}</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="card">
                        <div class="label">{{ trans_db('online') }}</div>
                        <div style="font-weight: bold;">₹{{ number_format($summary['online'], 0) }}</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="card">
                        <div class="label">{{ trans_db('upi') }}</div>
                        <div style="font-weight: bold;">₹{{ number_format($summary['upi'], 0) }}</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="card">
                        <div class="label">{{ trans_db('card') }}</div>
                        <div style="font-weight: bold;">₹{{ number_format($summary['card'], 0) }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2 style="font-size: 14px; color: #111827; margin-bottom: 10px;">{{ trans_db('detailed_transactions') }}</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ trans_db('time') }}</th>
                <th>{{ trans_db('guest') }}</th>
                <th>{{ trans_db('booking_id') }}</th>
                <th>{{ trans_db('mode') }}</th>
                <th class="text-right">{{ trans_db('amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('h:i A') }}</td>
                    <td>
                        {{ $payment->booking->guest->first_name }} {{ $payment->booking->guest->last_name }}<br>
                        <span style="font-size: 9px; color: #666;">{{ $payment->booking->guest->mobile_number }}</span>
                    </td>
                    <td>#{{ $payment->booking_id }}</td>
                    <td>{{ strtoupper($payment->payment_mode) }}</td>
                    <td class="text-right">₹{{ number_format($payment->amount, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ trans_db('generated_on') }}: {{ now()->format('Y-m-d h:i A') }} | Shree Ram Trust Dharamshala Connect
    </div>
</body>

</html>