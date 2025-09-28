<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {

    // Get current user data
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('task', TaskController::class);

});
