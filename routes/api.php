<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::prefix('game')->group(function () {
    Route::post('/new', [GameController::class, 'newGame']);
    Route::get('/{id}', [GameController::class, 'getGame']);
    Route::post('/{id}/move', [GameController::class, 'makeMove']);
    Route::post('/{id}/reset', [GameController::class, 'resetGame']);
});