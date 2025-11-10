<?php

use App\Http\Controllers\Api\V1\PrimarySectorController;
use App\Http\Controllers\Api\V1\RegisterNgoController;
use App\Http\Controllers\Api\V1\SdgsController;
use Illuminate\Support\Facades\Route;

// routing for API v1
Route::prefix('v1')->group(function () {

    Route::get('primary-sectors', [PrimarySectorController::class, 'getPrimarySectors']);

    Route::get('sdgs', [SdgsController::class, 'getSdgs']);
});
