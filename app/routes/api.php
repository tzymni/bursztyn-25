<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserAuthController::class,'register']);

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});
