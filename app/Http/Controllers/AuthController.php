<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        // 1. Validate input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // 2. Generate 4-digit OTP
        $otp = rand(1000, 9999);

        // 3. Save OTP to database
        Otp::create([
            'phone' => $request->phone,
            'otp' => $otp,
        ]);

        // 4. For now, return OTP in response (in real apps, send via SMS)
        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp // Show in response for now
        ]);
    }

    public function verifyOtp(Request $request)
{
    // 1. Validate input
    $validator = Validator::make($request->all(), [
        'phone' => 'required|digits:10',
        'otp' => 'required|digits:4',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // 2. Find latest OTP for this phone
    $otpEntry = Otp::where('phone', $request->phone)
                   ->orderBy('created_at', 'desc')
                   ->first();

    if (!$otpEntry) {
        return response()->json(['error' => 'OTP not found. Please request a new one.'], 404);
    }

    // 3. Check OTP match
    if ($otpEntry->otp != $request->otp) {
        return response()->json(['error' => 'Invalid OTP.'], 401);
    }

    // 4. Check OTP expiration (5 minutes)
    $expiresAt = $otpEntry->created_at->addMinutes(5);
    if (now()->greaterThan($expiresAt)) {
        return response()->json(['error' => 'OTP expired. Please request a new one.'], 410);
    }

    // 5. Find or create user by phone
    $user = User::firstOrCreate(
        ['phone' => $request->phone],
        ['name' => 'User' . substr($request->phone, -4)] // default name; customize as needed
    );

    // 6. Create Sanctum token
    $token = $user->createToken('auth_token')->plainTextToken;

    // 7. Return success response with token
    return response()->json([
        'message' => 'OTP verified successfully',
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
}