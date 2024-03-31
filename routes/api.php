<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvaliationController;


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

   Route::post('logout', [AuthController::class, 'logout']);

});

Route::post('login', [AuthController::class, 'store']);


