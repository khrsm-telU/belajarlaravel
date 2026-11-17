<?php

use App\Http\Controllers\Api\FolkloreApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| StoryQuest REST API — Modul 7 (GET Folklore Indonesia) & Modul 8 (POST Skor)
| Base URL: http://kelompok10.202.10.47.91.sslip.io/api
|--------------------------------------------------------------------------
*/

// Modul 7: GET Daftar Cerita Rakyat / Folklore Indonesia
Route::get('/', [FolkloreApiController::class, 'index']);
Route::get('/stories', [FolkloreApiController::class, 'index']);
Route::get('/posts', [FolkloreApiController::class, 'index']);
Route::get('/folklore', [FolkloreApiController::class, 'index']);
Route::get('/stories/{id}', [FolkloreApiController::class, 'show']);
Route::get('/folklore/{id}', [FolkloreApiController::class, 'show']);

// Modul 7 Langkah 6.3: Endpoint simulasi delay untuk pengujian timeout
Route::get('/delay/{seconds?}', [FolkloreApiController::class, 'delay']);

// Modul 8: POST Pengiriman Poin (ScoreSubmission -> ScoreResponse)
Route::post('/', [FolkloreApiController::class, 'submitScore']);
Route::post('/scores', [FolkloreApiController::class, 'submitScore']);
Route::post('/posts', [FolkloreApiController::class, 'submitScore']);
Route::post('/submit-score', [FolkloreApiController::class, 'submitScore']);

// Endpoint tambahan untuk melihat Leaderboard / Daftar Skor
Route::get('/scores', [FolkloreApiController::class, 'leaderboard']);
Route::get('/leaderboard', [FolkloreApiController::class, 'leaderboard']);
