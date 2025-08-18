<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardLog;
use App\Models\RewardCatalog; // import the model here, outside class
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    // Earn points
    public function earn(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'action_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $reward = Reward::create([
            'user_id' => auth()->id(),
            'points_earned' => $request->points,
            'action_type' => $request->action_type,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Reward points added successfully',
            'data' => $reward,
        ]);
    }

    // Redeem points
    public function redeem(Request $request)
    {
        $request->validate([
            'catalog_id' => 'required|integer|exists:reward_catalogs,id'
        ]);

        $user = Auth::user();
        $reward = Reward::where('user_id', $user->id)->first();
        $catalog = RewardCatalog::findOrFail($request->catalog_id);

        if (!$reward || $reward->points_earned < $catalog->points_required) {
            return response()->json(['message' => 'Not enough points'], 400);
        }

        // Deduct points
        $reward->points_earned -= $catalog->points_required;
        $reward->save();

        // Log redemption
        RewardLog::create([
            'user_id' => $user->id,
            'action_type' => 'redeem',
            'points' => -$catalog->points_required,
            'description' => "Redeemed reward: {$catalog->name}"
        ]);

        return response()->json([
            'message' => 'Reward redeemed successfully',
            'balance' => $reward->points_earned
        ]);
    }

    // Reward history
    public function history()
    {
        $user = Auth::user();

        $logs = RewardLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'history' => $logs,
        ]);
    }
}
