<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post( '/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

Route::post('/events/{event}/register', [RegistrationController::class, 'register']);
    Route::delete('/events/{event}/unregister', [RegistrationController::class, 'unregister']);
    Route::get('/events/{event}/attendees/pdf', [EventController::class, 'attendeesPdf']);
});
