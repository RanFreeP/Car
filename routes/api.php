<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminCarController;
use App\Http\Controllers\UseCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function() {
    Route::post('car/create', [AdminCarController::class, 'create']);
    Route::put('car/{id}', [AdminCarController::class, 'update']);
    Route::delete('car/{id}', [AdminCarController::class, 'destroy']);

    Route::post('user/create', [UserController::class, 'create']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'destroy']);

    Route::post('useCar', [UseCarController::class, 'useCar']);
});


     Route::post('auth', [AuthController::class, 'auth']);

