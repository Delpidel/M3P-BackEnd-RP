<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('students', [StudentController::class, 'store']);
});
