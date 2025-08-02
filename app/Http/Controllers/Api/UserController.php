<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;

class UserController extends Controller
{
     public function __construct(protected UserService $service) {}

    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'User profile fetched successfully',
            'data' => $this->service->view($request->user())
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->service->update($request->user(), $request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    public function upgradeToSeller(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
        ]);

        $user = $this->service->upgradeToSeller($request->user(), $request->business_name);

        return response()->json([
            'status' => true,
            'message' => 'Upgraded to seller',
            'data' => $user
        ]);
    }
}
