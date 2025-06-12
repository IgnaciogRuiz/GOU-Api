<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisterVerificationController;
use Illuminate\Support\Facades\Route;




Route::prefix('/auth')->group(function () {
    Route::prefix('register')->controller(RegisterVerificationController::class)->group(function () {
        Route::post('/verify-email', 'verifyEmail');
        Route::post('/verify-phone', 'verifyPhone');
        Route::post('/verify-email-token', 'verifyEmailToken');
        Route::post('/verify-phone-token', 'verifyPhoneToken');
        Route::post('/verify-identity', 'verifyIdentity');
        Route::post('/verify-password', 'verifyPassword');
    });

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:api')
        ->name('logout');
});
