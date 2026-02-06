<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send WhatsApp message via Twilio
     */
    public function sendWhatsApp(string $to, string $message): bool
    {
        try {
            $accountSid = config('services.twilio.sid');
            $authToken = config('services.twilio.token');
            $from = config('services.twilio.whatsapp_from');

            if (!$accountSid || !$authToken) {
                Log::warning('Twilio credentials not configured');
                return false;
            }

            $response = Http::withBasicAuth($accountSid, $authToken)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                    'From' => "whatsapp:{$from}",
                    'To' => "whatsapp:{$to}",
                    'Body' => $message
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send SMS via Twilio
     */
    public function sendSMS(string $to, string $message): bool
    {
        try {
            $accountSid = config('services.twilio.sid');
            $authToken = config('services.twilio.token');
            $from = config('services.twilio.phone_number');

            if (!$accountSid || !$authToken) {
                Log::warning('Twilio credentials not configured');
                return false;
            }

            $response = Http::withBasicAuth($accountSid, $authToken)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                    'From' => $from,
                    'To' => $to,
                    'Body' => $message
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('SMS send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send booking confirmation notification
     */
    public function sendBookingConfirmation(Booking $booking): bool
    {
        $message = "🏨 Booking Confirmed!\n\n";
        $message .= "Booking ID: #{$booking->id}\n";
        $message .= "Guest: {$booking->guest->first_name} {$booking->guest->last_name}\n";
        $message .= "Check-in: " . \Carbon\Carbon::parse($booking->check_in)->format('d M Y, h:i A') . "\n";
        $message .= "Check-out: " . \Carbon\Carbon::parse($booking->check_out)->format('d M Y, h:i A') . "\n";
        $message .= "Total Amount: ₹" . number_format($booking->total_amount, 0) . "\n\n";
        $message .= "Thank you for choosing Dharamshala Connect!";

        $mobile = $booking->guest->mobile_number;

        // Try WhatsApp first, fallback to SMS
        if (!$this->sendWhatsApp($mobile, $message)) {
            return $this->sendSMS($mobile, $message);
        }

        return true;
    }

    /**
     * Send payment receipt notification
     */
    public function sendPaymentReceipt(Booking $booking, float $amount, string $mode): bool
    {
        $message = "💳 Payment Received!\n\n";
        $message .= "Booking ID: #{$booking->id}\n";
        $message .= "Amount: ₹" . number_format($amount, 0) . "\n";
        $message .= "Mode: " . strtoupper($mode) . "\n";
        $message .= "Balance: ₹" . number_format($booking->total_amount - $booking->paid_amount, 0) . "\n\n";
        $message .= "Thank you!";

        $mobile = $booking->guest->mobile_number;

        if (!$this->sendWhatsApp($mobile, $message)) {
            return $this->sendSMS($mobile, $message);
        }

        return true;
    }

    /**
     * Send check-in reminder (1 day before)
     */
    public function sendCheckInReminder(Booking $booking): bool
    {
        $message = "🔔 Check-in Reminder\n\n";
        $message .= "Your check-in is tomorrow!\n";
        $message .= "Booking ID: #{$booking->id}\n";
        $message .= "Check-in: " . \Carbon\Carbon::parse($booking->check_in)->format('d M Y, h:i A') . "\n";
        $message .= "Please carry a valid ID proof.\n\n";
        $message .= "See you soon!";

        $mobile = $booking->guest->mobile_number;

        if (!$this->sendWhatsApp($mobile, $message)) {
            return $this->sendSMS($mobile, $message);
        }

        return true;
    }
}
