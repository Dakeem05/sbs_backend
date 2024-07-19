<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\BusinessController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('isAuthenticated')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('user', [AuthenticationController::class, 'getUser']);
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
    });

    Route::prefix('business')->group(function () {
        Route::resource('', BusinessController::class);
        Route::post('/update/{id}', [BusinessController::class, 'update']);
        Route::get('/find/{short_name}', [BusinessController::class, 'find']);
    });

    Route::prefix('menu')->group(function () {
        Route::get('/{business_uuid}', [MenuController::class, 'index']);
        Route::post('', [MenuController::class, 'store']);
        Route::get('/show/{uuid}', [MenuController::class, 'show']);
        Route::post('/{uuid}', [MenuController::class, 'update']);
        Route::delete('/{uuid}', [MenuController::class, 'destroy']);
    });    
});