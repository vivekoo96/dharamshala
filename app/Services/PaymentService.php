<?php

namespace App\Services;

use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\Booking;

class PaymentService
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    /**
     * Create a Razorpay order for online payment
     */
    public function createOrder(Booking $booking, float $amount): array
    {
        try {
            $order = $this->razorpay->order->create([
                'amount' => $amount * 100, // Amount in paise
                'currency' => 'INR',
                'receipt' => 'booking_' . $booking->id,
                'notes' => [
                    'booking_id' => $booking->id,
                    'guest_name' => $booking->guest->first_name . ' ' . $booking->guest->last_name
                ]
            ]);

            return [
                'order_id' => $order['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'key' => config('services.razorpay.key')
            ];
        } catch (\Exception $e) {
            \Log::error('Razorpay order creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify Razorpay payment signature
     */
    public function verifyPayment(string $orderId, string $paymentId, string $signature): bool
    {
        try {
            $attributes = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            \Log::error('Payment verification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Record a payment (online or cash)
     */
    public function recordPayment(Booking $booking, float $amount, string $mode, ?string $transactionId = null): Payment
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $amount,
            'payment_mode' => $mode, // 'online', 'cash', 'upi', 'card'
            'transaction_id' => $transactionId,
            'status' => 'completed'
        ]);

        // Update booking paid amount
        $booking->increment('paid_amount', $amount);

        // Update booking status if fully paid
        if ($booking->paid_amount >= $booking->total_amount) {
            $booking->update(['status' => 'confirmed']);
        }

        return $payment;
    }

    /**
     * Process refund
     */
    public function processRefund(Payment $payment, float $amount): bool
    {
        try {
            if ($payment->payment_mode === 'online' && $payment->transaction_id) {
                $refund = $this->razorpay->payment->fetch($payment->transaction_id)->refund([
                    'amount' => $amount * 100
                ]);

                // Record refund
                Payment::create([
                    'booking_id' => $payment->booking_id,
                    'amount' => -$amount,
                    'payment_mode' => 'refund',
                    'transaction_id' => $refund['id'],
                    'status' => 'completed'
                ]);

                $payment->booking->decrement('paid_amount', $amount);
                return true;
            }

            // For cash refunds, just record the transaction
            Payment::create([
                'booking_id' => $payment->booking_id,
                'amount' => -$amount,
                'payment_mode' => 'cash_refund',
                'status' => 'completed'
            ]);

            $payment->booking->decrement('paid_amount', $amount);
            return true;
        } catch (\Exception $e) {
            \Log::error('Refund processing failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get daily cash collection
     */
    public function getDailyCashCollection(\DateTime $date): array
    {
        $payments = Payment::whereDate('created_at', $date)
            ->whereIn('payment_mode', ['cash', 'upi'])
            ->get();

        return [
            'total' => $payments->sum('amount'),
            'count' => $payments->count(),
            'breakdown' => [
                'cash' => $payments->where('payment_mode', 'cash')->sum('amount'),
                'upi' => $payments->where('payment_mode', 'upi')->sum('amount')
            ]
        ];
    }
}
