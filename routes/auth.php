<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');
    
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('resend/{email}', 'resend');
        Route::post('verify', 'verify');
        Route::post('forgot-password', 'forgotPassword');
        Route::post('verify-forgot-password', 'verifyForgotPassword');
        Route::post('resend-forgot-password', 'resendForgotPassword');
        Route::post('change-password', 'changePassword');
    });
});