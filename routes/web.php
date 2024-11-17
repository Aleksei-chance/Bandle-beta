<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandleController;
use App\Http\Controllers\LogicController;
use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/auth', [AuthController::class, 'view'])->middleware(AuthCheck::class);
Route::get('/collection', [CollectionController::class, 'view'])->middleware(AuthCheck::class);

Route::post('/logic/user', [LogicController::class, 'user']);
Route::post('/logic/collection', [LogicController::class, 'collection']);
Route::post('/logic/bandle', [LogicController::class, 'bandle']);
Route::post('/logic/block', [LogicController::class, 'block']);


Route::get('/bandle/{bandle}', [BandleController::class, 'view']);


