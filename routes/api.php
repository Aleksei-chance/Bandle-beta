<?php

use App\Http\Controllers\LogicUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user', [LogicUserController::class, 'connect']);
