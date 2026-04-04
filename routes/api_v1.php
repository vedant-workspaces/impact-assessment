<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\PrimarySectorController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\ProgramController;
use App\Http\Controllers\Api\V1\SdgsController;
use App\Http\Controllers\Api\V1\SurveyController;
use Illuminate\Support\Facades\Route;

// routing for API v1
Route::prefix('v1')->group(function () {

    Route::post('register-ngo', [NgoController::class, 'registerNgo']);

    Route::get('primary-sectors', [PrimarySectorController::class, 'getPrimarySectors']);

    Route::get('sdgs', [SdgsController::class, 'getSdgs']);

    Route::post('auth/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

    Route::post('auth/refresh', [LoginController::class, 'refresh']);

    Route::post('auth/logout', [LoginController::class, 'logout']);

    // Member creation: Super Admins, Project Managers, Supervisors
    Route::middleware(['jwt', 'role:1,2,3'])->group(function () {
        Route::post('add-members', [MemberController::class, 'add']);
    });

    // Members listing: Super Admins and Project Managers
    Route::middleware(['jwt', 'role:1,2'])->group(function () {
        Route::get('members', [MemberController::class, 'get']);
    });

    // Programs management (create/edit/delete): Super Admins and Project Managers
    Route::middleware(['jwt', 'role:1,2'])->group(function () {
        Route::post('add-program', [ProgramController::class, 'add']);
        Route::post('delete-program', [ProgramController::class, 'deleteProgram']);
        Route::post('programs/edit', [ProgramController::class, 'edit']);
    });

    // Programs view: Super Admins, Project Managers, Supervisors
    Route::middleware(['jwt', 'role:1,2,3'])->group(function () {
        Route::get('programs/names', [ProgramController::class, 'getProgramNames']);
        Route::get('programs', [ProgramController::class, 'getProgramsWithMembers']);
        Route::get('programs/details', [ProgramController::class, 'getDetails']);
    });

    // Surveys: adding and viewing allowed for Super Admins, Project Managers, Supervisors
    Route::middleware(['jwt', 'role:1,2,3'])->group(function () {
        Route::post('add-survey', [SurveyController::class, 'add']);
        Route::get('surveys/names', [SurveyController::class, 'getSurveyNames']);
        Route::get('surveys', [SurveyController::class, 'getSurveysWithMembers']);
        Route::get('surveys/details', [SurveyController::class, 'getDetails']);
    });

    // Surveys management (edit/delete): Super Admins and Project Managers
    Route::middleware(['jwt', 'role:1,2'])->group(function () {
        Route::post('surveys/edit', [SurveyController::class, 'edit']);
        Route::post('delete-survey', [SurveyController::class, 'deleteSurvey']);
    });

});
