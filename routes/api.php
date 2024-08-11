<?php

use Proton\Http\Route;
use App\Controllers\AuthController;

Route::get('/api/login',[AuthController::class, 'login']);
Route::get('/api/register',[AuthController::class, 'register']);
Route::get('/api/index',[AuthController::class, 'index']);

