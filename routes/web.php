<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PublicGameController;
use App\Http\Controllers\DataController;



Route::get('/', [HomeController::class, 'index']);
//studio routes
Route::get('/studios', [StudioController::class, 'list']);
Route::get('/studios/create', [StudioController::class, 'create']);
Route::post('/studios/put', [StudioController::class, 'put']);
Route::get('/studios/update/{studio}', [StudioController::class, 'update']);
Route::post('/studios/patch/{studio}', [StudioController::class, 'patch']);
Route::post('/studios/delete/{studio}', [StudioController::class, 'delete']);
//auth routes
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
// Genre routes
Route::get('/genres', [GenreController::class, 'list']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres/put', [GenreController::class, 'put']);
Route::get('/genres/update/{genre}', [GenreController::class, 'update']);
Route::post('/genres/patch/{genre}', [GenreController::class, 'patch']);
Route::post('/genres/delete/{genre}', [GenreController::class, 'delete']);
// Public JSON API for SPA
Route::get('/api/games/featured', [PublicGameController::class, 'featured']);
Route::get('/api/games/{game}', [PublicGameController::class, 'show']);
Route::get('/api/games/{game}/similar', [PublicGameController::class, 'similar']);
// Data/API
Route::get('/data/get-top-games', [DataController::class, 'getTopGames']);
Route::get('/data/get-game/{game}', [DataController::class, 'getGame']);
Route::get('/data/get-related-games/{game}', [DataController::class, 'getRelatedGames']);