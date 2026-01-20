<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/studios', [StudioController::class, 'list']);
Route::get('/studios/create', [StudioController::class, 'create']);
Route::post('/studios/put', [StudioController::class, 'put']);
Route::get('/studios/update/{studio}', [StudioController::class, 'update']);
Route::post('/studios/patch/{studio}', [StudioController::class, 'patch']);
Route::post('/studios/delete/{studio}', [StudioController::class, 'delete']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);
// Game routes
Route::get('/games', [GameController::class, 'list']);
Route::get('/games/create', [GameController::class, 'create']);
Route::post('/games/put', [GameController::class, 'put']);
Route::get('/games/update/{game}', [GameController::class, 'update']);
Route::post('/games/patch/{game}', [GameController::class, 'patch']);
Route::post('/games/delete/{game}', [GameController::class, 'delete']);

