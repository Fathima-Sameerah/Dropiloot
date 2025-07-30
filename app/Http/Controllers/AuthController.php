<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
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
}