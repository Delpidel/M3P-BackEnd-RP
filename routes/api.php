<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliationController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentExportController;
use App\Http\Controllers\StudentMealsController;
use App\Http\Controllers\StudentWorkoutController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\ExerciseInstructorController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\InstructorWorkoutController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
   Route::post('users', [UserController::class, 'store'])->middleware(['ability:create-users']);
   Route::get('users', [UserController::class, 'index'])->middleware(['ability:get-users']);
   Route::put('users/{id}', [UserController::class, 'update'])->middleware(['ability:update-users']);
   Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware(['ability:delete-users']);
   Route::get('users/{id}', [UserController::class, 'show'])->middleware(['ability:get-users']);
   Route::get('user/image', [UserController::class, 'getImage']);

   Route::get('dashboard/admin', [DashboardController::class, 'index'])->middleware(['ability:get-dashboard']);
   Route::get('dashboard/instrutor', [DashboardInstructorController::class, 'index'])->middleware(['ability:instrutor-dashboard']);

   Route::get('student/{id}/workouts', [StudentWorkoutController::class, 'workoutsByStudent'])->middleware(['ability:get-workout']);
   Route::get('student/meal_plans', [StudentMealsController::class, 'index'])->middleware(['ability:get-meal-plans']);
   Route::get('student/meal_plans/{id}', [StudentMealsController::class, 'show'])->middleware(['ability:get-meal-plans']);

   Route::get('students', [StudentController::class, 'index'])->middleware(['ability:get-students']);
   Route::post('students', [StudentController::class, 'store'])->middleware(['ability:create-students']);
   Route::put('students/{id}', [StudentController::class, 'update'])->middleware(['ability:update-students']);
   Route::delete('students/{id}', [StudentController::class, 'destroy'])->middleware(['ability:delete-students']);
   Route::get('students/{id}', [StudentController::class, 'show'])->middleware(['ability:get-students']);

   Route::get('students/{id}/workouts', [InstructorWorkoutController::class, 'listWorkouts'])->middleware(['ability:get-workouts']);
   Route::get('workouts', [WorkoutController::class, 'index'])->middleware(['ability:get-workouts']);
   Route::post('workouts', [WorkoutController::class, 'store'])->middleware(['ability:create-workouts']);

   Route::get('meal_plans', [MealPlanController::class, 'index'])->middleware(['ability:get-meal-plans']);
   Route::post('meal_plans', [MealPlanController::class, 'store'])->middleware(['ability:create-meal-plans']);
   Route::get('meal/{id}', [MealPlanScheduleController::class, 'studentMeal'])->middleware(['ability:get-meal-plans']);
   Route::get('meals', [MealPlanScheduleController::class, 'index'])->middleware(['ability:get-meal-plans']);
   Route::post('cad_meal', [MealPlanScheduleController::class, 'store'])->middleware(['ability:create-meal-plans']);
   Route::put('update_meal/{id}', [MealPlanScheduleController::class, 'update'])->middleware(['ability:update-meal-plans']);
   Route::delete('delete_meal/{id}', [MealPlanScheduleController::class, 'destroy'])->middleware(['ability:delete-meal-plans']);

   Route::get('/exercises', [ExerciseInstructorController::class, 'index']);
   Route::post('exercises', [ExerciseController::class, 'store'])->middleware(['ability:create-exercises']);
   Route::delete('exercises/{id}', [ExerciseController::class, 'destroy'])->middleware(['ability:delete-exercises']);

   Route::put('workouts/{id}', [WorkoutController::class, 'update'])->middleware(['ability:get-workouts']);
   Route::delete('workouts/{id}', [WorkoutController::class, 'destroy'])->middleware(['ability:delete-workouts']);

   Route::post('students/{id}/documents', [StudentDocumentController::class, 'storeDocuments'])->middleware(['ability:create-documents-students']);
   Route::get('/avaliations/{student_id}', [AvaliationController::class, 'getAvaliationsByStudentId']);
   Route::get('avaliations/export/{id}', [StudentExportController::class, 'export']);
   Route::get('avaliations/send/{id}', [StudentExportController::class, 'index']);
   Route::get('students/avaliations/{id}', [AvaliationController::class, 'index']);

   //rotas para cadastro de avaliações em 3 etapas
   Route::prefix('avaliations')->group(function () {
      Route::post('step1', [AvaliationController::class, 'step1']);
      Route::post('step2', [AvaliationController::class, 'step2']);
      Route::post('step3', [AvaliationController::class, 'step3']);
   })->middleware(['ability:create-avaliations']);

   Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'store']);
