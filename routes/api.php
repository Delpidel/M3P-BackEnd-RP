<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvaliationController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('students', [StudentController::class, 'index']);
    Route::get('workouts', [WorkoutController::class, 'index']);
    Route::get('avaliations', [AvaliationController::class, 'index']);
});

Route::post('login', [AuthController::class, 'store']);
