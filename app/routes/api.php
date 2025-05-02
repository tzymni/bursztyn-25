<?php

use App\Http\Controllers\{UserAuthController, UserController};
use Illuminate\Support\Facades\Route;

Route::controller(UserAuthController::class)->group(function(){
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->apiResource('users', UserController::class);
