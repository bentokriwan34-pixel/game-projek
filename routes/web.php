<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'index'])->name('game.index');
Route::get('/game/{id}', [GameController::class, 'showGame'])->name('game.show');
