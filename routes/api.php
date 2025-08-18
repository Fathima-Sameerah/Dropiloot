<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DropController;
use App\Http\Controllers\RewardController;


Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/drops/{id}/category', [CategoryController::class, 'assign']);
    Route::get('/drops', [DropController::class, 'index']); // list all drops
    Route::get('/drops/{id}', [DropController::class, 'show']); // view a single drop
    Route::post('/drops', [DropController::class, 'store']); // create drop
    Route::put('/drops/{id}', [DropController::class, 'update']); // update drop
    Route::delete('/drops/{id}', [DropController::class, 'destroy']); // delete drop
    Route::post('/rewards/earn', [RewardController::class, 'earn']);
    Route::post('/rewards/redeem', [RewardController::class, 'redeem']);
    Route::get('/rewards/history', [RewardController::class, 'history']);
});
