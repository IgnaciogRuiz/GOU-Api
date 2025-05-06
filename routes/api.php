<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('users', App\Http\Controllers\UserController::class);
    Route::apiResource('vehicles', App\Http\Controllers\VehicleController::class);
    Route::apiResource('trips', App\Http\Controllers\TripController::class);
    Route::apiResource('tags', App\Http\Controllers\TagController::class);
    Route::apiResource('allows', App\Http\Controllers\AllowsController::class);
    Route::apiResource('reservations', App\Http\Controllers\ReservationController::class);
    Route::apiResource('payments', App\Http\Controllers\PaymentController::class);
    Route::apiResource('transactions', App\Http\Controllers\TransactionController::class);
    Route::apiResource('chats', App\Http\Controllers\ChatController::class);
    Route::apiResource('messages', App\Http\Controllers\MessageController::class);
    Route::apiResource('ratings', App\Http\Controllers\RatingController::class);
    Route::apiResource('driver-blocks', App\Http\Controllers\DriverBlockController::class);
});


Route::apiResource('commissions', App\Http\Controllers\CommissionController::class);
