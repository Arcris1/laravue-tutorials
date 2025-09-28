<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {

    // Get current user data
    Route::get('/me', [UserController::class, 'meDetails']);

    // Logged out the current user
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('task', TaskController::class);
});
