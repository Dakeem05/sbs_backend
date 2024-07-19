<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
                    ->middleware('guest')
                    ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                    ->middleware('guest')
                    ->name('login');

    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    //                 ->middleware('guest')
    //                 ->name('password.email');

    // Route::post('/reset-password', [NewPasswordController::class, 'store'])
    //                 ->middleware('guest')
    //                 ->name('password.store');

    // Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    //                 ->middleware(['auth', 'signed', 'throttle:6,1'])
    //                 ->name('verification.verify');

    // Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //                 ->middleware(['auth', 'throttle:6,1'])
    //                 ->name('verification.send');

    
    Route::controller(AuthenticationController::class)->group(function () {
        // Route::post('register', 'register');
        // Route::post('login', 'login');
        Route::get('resend/{email}', 'resend');
        Route::post('verify', 'verify');
        Route::post('forgot-password', 'forgotPassword');
        Route::post('verify-forgot-password', 'verifyForgotPassword');
        Route::post('resend-forgot-password', 'resendForgotPassword');
        Route::post('change-password', 'changePassword');
    });
});