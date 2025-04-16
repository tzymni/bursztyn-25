<?php

use App\Http\Controllers\{UserAuthController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user/list', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserAuthController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
//

Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/user/list', 'index');
});

//Route::middleware('auth:sanctum')->group( function () {
//    Route::resource('products', UserController::class);
//});
