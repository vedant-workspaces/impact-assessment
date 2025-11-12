<?php

use App\Http\Controllers\Api\V1\PrimarySectorController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\SdgsController;
use Illuminate\Support\Facades\Route;

// routing for API v1
Route::prefix('v1')->group(function () {

    Route::post('register-ngo', [NgoController::class, 'registerNgo']);

    Route::get('primary-sectors', [PrimarySectorController::class, 'getPrimarySectors']);

    Route::get('sdgs', [SdgsController::class, 'getSdgs']);
});
