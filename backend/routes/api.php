<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;


// Public routes
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
});