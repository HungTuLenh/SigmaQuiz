<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);


Route::get('/user', [UserController::class, 'getUsers']);
Route::get('/user/all', [UserController::class, 'getAllUsers']);
Route::post('/user', [UserController::class, 'createUser']);
Route::put('/user', [UserController::class, 'updateUser']); 
Route::delete('/user', [UserController::class, 'deleteUser']); 