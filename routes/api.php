<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('students', [StudentController::class, 'index']);
    Route::get('workouts', [WorkoutController::class, 'index']);
    Route::post('workouts', [WorkoutController::class, 'store'])->middleware(['ability:create-workouts']);
});

Route::post('login', [AuthController::class, 'store']);