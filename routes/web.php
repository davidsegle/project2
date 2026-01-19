<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudioController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/studios', [StudioController::class, 'list']);
Route::get('/studios/create', [StudioController::class, 'create']);
Route::post('/studios/put', [StudioController::class, 'put']);
Route::get('/studios/update/{studio}', [StudioController::class, 'update']);
Route::post('/studios/patch/{studio}', [StudioController::class, 'patch']);
Route::post('/studios/delete/{studio}', [StudioController::class, 'delete']);

