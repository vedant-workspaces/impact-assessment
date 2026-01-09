<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\PrimarySectorController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\ProgramController;
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

    Route::middleware(['jwt', 'role:1'])->group(function () {
        Route::post('add-members', [MemberController::class, 'add']);
    });

    Route::middleware(['jwt', 'role:1'])->group(function () {
        Route::get('members', [MemberController::class, 'get']);
    });

    // Route::middleware(['jwt', 'role:1'])->group(function () {
    Route::middleware(['jwt'])->group(function () {
        Route::post('add-program', [ProgramController::class, 'add']);
    });

});
