<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LeaderboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ClubController::class, 'index'])->name('clubs');
Route::get('clubs/create', [ClubController::class, 'create'])->name('clubs.create');
Route::post('clubs/store', [ClubController::class, 'store'])->name('clubs.store');

Route::get('scores', [ScoreController::class, 'index'])->name('scores');
Route::post('scores', [ScoreController::class, 'store'])->name('scores.store');
Route::post('scores-single', [ScoreController::class, 'storeSingle'])->name('scores.storeSingle');

Route::get('leaderboards', [LeaderboardController::class, 'index'])->name('leaderboards');
