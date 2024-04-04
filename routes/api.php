<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentMealsController;
use App\Http\Controllers\StudentWorkoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;

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
    Route::post('users', [UserController::class, 'store'])->middleware(['ability:create-users']);
    Route::get('users', [UserController::class, 'index'])->middleware(['ability:get-users']);
    Route::get('users/{id}', [UserController::class, 'show'])->middleware(['ability:get-users']);
    Route::put('users/{id}', [UserController::class, 'update'])->middleware(['ability:update-users']);
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware(['ability:delete-users']);

    Route::get('dashboard/admin', [DashboardController::class, 'index'])->middleware(['ability:get-dashboard']);

    Route::get('students/{id}/workouts', [StudentWorkoutController::class, 'workoutsByStudent'])->middleware(['ability:get-workout']);
    Route::get('students/meal_plans', [StudentMealsController::class, 'index'])->middleware(['ability:get-meal-plans']);;
    Route::get('students/meal_plans/{id}', [StudentMealsController::class, 'show'])->middleware(['ability:get-meal-plans']);;

    Route::get('students', [StudentController::class, 'index'])->middleware(['ability:get-students']);
    Route::post('students', [StudentController::class, 'store'])->middleware(['ability:create-students']);
    Route::get('workouts', [WorkoutController::class, 'index'])->middleware(['ability:get-workouts']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'store']);
