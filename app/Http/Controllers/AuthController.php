<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile_number' => 'required|string']);

        $otp = rand(1000, 9999);
        $user = User::firstOrCreate(
            ['mobile_number' => $request->mobile_number],
            ['name' => 'Guest User', 'role' => 'staff'] // Default role, usually updated by admin
        );

        $user->update(['otp' => $otp]);

        // In production, send via SMS/WhatsApp. For now, log it.
        Log::info("OTP for {$request->mobile_number}: {$otp}");

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string',
            'otp' => 'required|string'
        ]);

        $user = User::where('mobile_number', $request->mobile_number)
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid OTP'], 401);
        }

        Auth::login($user);
        $user->update(['otp' => null]); // Clear OTP after login

        return response()->json(['message' => 'Logged in successfully', 'user' => $user]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return redirect()->route('home');
    }
}
