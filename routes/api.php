<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanScheduleController;
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
});

Route::post('login', [AuthController::class, 'store']);


//MINHAS ROTAS

Route::get('meal_plans', [MealPlanController::class, 'index']);
Route::post('meal_plans', [MealPlanController::class, 'store']);

Route::get('meals', [MealPlanScheduleController::class, 'index']);
Route::post('cad_meal', [MealPlanScheduleController::class, 'store']);
Route::put('update_meal/{id}', [MealPlanScheduleController::class, 'update']);
Route::delete('delete_meal/{id}', [MealPlanScheduleController::class, 'destroy']);

