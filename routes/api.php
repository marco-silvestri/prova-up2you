<?php

use App\Http\Controllers\AttendeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscribeAttendeeToEventController;
use App\Http\Middleware\CustomTokenAuth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('attendees', AttendeeController::class)->middleware(CustomTokenAuth::class);
Route::apiResource('events', EventController::class)->middleware(CustomTokenAuth::class);
Route::post('subscribe-to-event', SubscribeAttendeeToEventController::class)->middleware(CustomTokenAuth::class);
