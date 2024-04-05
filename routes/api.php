<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliationController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\ExerciseInstructorController;
use App\Http\Controllers\WorkoutController;

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

   Route::post('avaliations', [AvaliationController::class, 'store'])->middleware(['ability:create-avaliations']);

   Route::get('meal_plans', [MealPlanController::class, 'index']);
   Route::post('meal_plans', [MealPlanController::class, 'store']);


   Route::get('meal_plans', [MealPlanController::class, 'index'])->middleware(['ability:get-meal-plans']);
   Route::post('meal_plans', [MealPlanController::class, 'store'])->middleware(['ability:create-meal-plans']);

   Route::get('meal/{id}', [MealPlanScheduleController::class, 'studentMeal'])->middleware(['ability:get-meal-plans']);
   Route::get('meals', [MealPlanScheduleController::class, 'index'])->middleware(['ability:get-meal-plans']);
   Route::post('cad_meal', [MealPlanScheduleController::class, 'store'])->middleware(['ability:create-meal-plans']);
   Route::put('update_meal/{id}', [MealPlanScheduleController::class, 'update'])->middleware(['ability:update-meal-plans']);
   Route::delete('delete_meal/{id}', [MealPlanScheduleController::class, 'destroy'])->middleware(['ability:delete-meal-plans']);

   Route::get('dashboard/instrutor', [DashboardInstructorController::class, 'index']);

   Route::get('/exercises', [ExerciseInstructorController::class, 'index']);
   Route::post('exercises', [ExerciseController::class, 'store'])->middleware(['ability:create-exercises']);
   Route::delete('exercises/{id}', [ExerciseController::class, 'destroy'])->middleware(['ability:delete-exercises']);

   Route::put('workouts/{id}', [WorkoutController::class, 'update'])->middleware(['ability:get-workouts']);
   Route::delete('workouts/{id}', [WorkoutController::class, 'destroy'])->middleware(['ability:delete-workouts']);

   Route::post('logout', [AuthController::class, 'logout']);

});

Route::post('login', [AuthController::class, 'store']);


