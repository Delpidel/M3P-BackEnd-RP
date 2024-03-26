<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\ExerciseInstructorController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::get('students', [StudentController::class, 'index'])->middleware(['ability:get-students']);
    Route::get('workouts', [WorkoutController::class, 'index'])->middleware(['ability:get-workouts']);
    Route::get('dashboard/instrutor', [DashboardInstructorController::class, 'index']);
    Route::get('/exercises', [ExerciseInstructorController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store'])->middleware(['ability:create-exercises']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy'])->middleware(['ability:delete-exercises']);
    Route::put('workouts/{id}', [WorkoutController::class, 'update'])->middleware(['ability:get-workouts']);
    Route::delete('workouts/{id}', [WorkoutController::class, 'destroy'])->middleware(['ability:delete-workouts']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'store']);
