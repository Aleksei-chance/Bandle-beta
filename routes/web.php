<?php

use App\Http\Controllers\LogicUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandleController;
use App\Http\Controllers\LogicBandleController;
use App\Http\Controllers\LogicBandleBlockController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/auth', [AuthController::class, 'view'])->middleware(AuthCheck::class);
Route::get('/user/{type}', [UserController::class, 'view'])->middleware(AuthCheck::class);

Route::post('/logic/user', [LogicController::class, 'user']);
Route::post('/logic/bandle', [LogicBandleController::class, 'connect']);
Route::post('/logic/block', [LogicBandleBlockController::class, 'connect']);


Route::get('/bandle/{bandle}', [BandleController::class, 'view']);


