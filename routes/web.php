<?php

use App\Http\Controllers\LogicUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/auth', [AuthController::class, 'view'])->middleware(AuthCheck::class);
Route::get('/user/{type}', [UserController::class, 'view'])->middleware(AuthCheck::class);

Route::post('/logic/user', [LogicUserController::class, 'connect']);


