<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\ExerciseInstructorController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\InstructorWorkoutController;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('users', [UserController::class, 'store'])->middleware(['ability:create-users']);
    Route::get('users', [UserController::class, 'index'])->middleware(['ability:get-users']);
    Route::put('users/{id}', [UserController::class, 'update'])->middleware(['ability:update-users']);
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware(['ability:delete-users']);

    Route::get('students', [StudentController::class, 'index'])->middleware(['ability:get-students']);
    Route::post('students', [StudentController::class, 'store'])->middleware(['ability:create-students']);

    Route::get('workouts', [WorkoutController::class, 'index'])->middleware(['ability:get-workouts']);

    Route::get('meal_plans', [MealPlanController::class, 'index']);
    Route::post('meal_plans', [MealPlanController::class, 'store']);

    Route::get('meal/{id}', [MealPlanScheduleController::class, 'studentMeal']);
    Route::get('meals', [MealPlanScheduleController::class, 'index']);
    Route::post('cad_meal', [MealPlanScheduleController::class, 'store']);
    Route::put('update_meal/{id}', [MealPlanScheduleController::class, 'update']);
    Route::delete('delete_meal/{id}', [MealPlanScheduleController::class, 'destroy']);

    Route::get('dashboard/instrutor', [DashboardInstructorController::class, 'index']);

    Route::get('/exercises', [ExerciseInstructorController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store'])->middleware(['ability:create-exercises']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy'])->middleware(['ability:delete-exercises']);

    Route::post('workouts', [WorkoutController::class, 'store'])->middleware(['ability:create-workouts']);
    Route::put('workouts/{id}', [WorkoutController::class, 'update'])->middleware(['ability:get-workouts']);
    Route::delete('workouts/{id}', [WorkoutController::class, 'destroy'])->middleware(['ability:delete-workouts']);
    Route::get('students/{id}/workouts', [InstructorWorkoutController::class, 'listWorkouts'])->middleware(['ability:get-workouts']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'store']);
