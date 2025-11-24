<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\PrimarySectorController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\SdgsController;
use Illuminate\Support\Facades\Route;

// routing for API v1
Route::prefix('v1')->group(function () {

    Route::post('register-ngo', [NgoController::class, 'registerNgo']);

    Route::get('primary-sectors', [PrimarySectorController::class, 'getPrimarySectors']);

    Route::get('sdgs', [SdgsController::class, 'getSdgs']);

    Route::post('auth/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

    Route::post('auth/refresh', [LoginController::class, 'refresh']);

    Route::post('auth/logout', [LoginController::class, 'logout']);

    /* 
        Example routings with JWT middleware

        Route::middleware('jwt')->group(function () {
            Route::get('/v1/ngo/dashboard', ...);
        });

        Example routings with JWT middleware and Role middleware

        Route::middleware(['jwt', 'role:1'])->group(function () {
            Route::get('/v1/ngo/dashboard', function () {
                return "NGO dashboard";
            });
        });

        Route::middleware(['jwt', 'role:2'])->group(function () {
            Route::get('/v1/donor/dashboard', function () {
                return "Donor dashboard";
            });
        });

        Route::middleware(['jwt', 'role:3'])->group(function () {
            Route::get('/v1/worker/dashboard', function () {
                return "Worker dashboard";
            });
        });
    */
});
