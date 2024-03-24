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
<<<<<<< HEAD

    Route::get('students', [StudentController::class, 'index']);
    Route::get('workouts', [WorkoutController::class, 'index']);

    Route::get('workouts', [WorkoutController::class, 'index']);
    Route::put('workouts/{id}', [WorkoutController::class, 'update']);
=======
    Route::get('students', [StudentController::class, 'index'])->middleware(['ability:get-students']);
    Route::get('workouts', [WorkoutController::class, 'index'])->middleware(['ability:get-workouts']);

    Route::post('logout', [AuthController::class, 'logout']);
>>>>>>> c903443f5b5e73474feb59d6aeb29937b8eb974c
});

Route::post('login', [AuthController::class, 'store']);
