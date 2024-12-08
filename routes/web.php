<?php

use Proton\Http\Route;
use App\Controllers\AuthController;

Route::get('/', [AuthController::class, 'index']);