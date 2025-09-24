<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::middleware(['password.auth'])->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('game.index');
    Route::get('/game/{id}', [GameController::class, 'showGame'])->name('game.show');
});

// Login route (not protected by middleware)
Route::post('/login', function (Illuminate\Http\Request $request) {
    $password = $request->input('password');
    $correctPassword = env('GAME_PASSWORD', 'tictactoe123');
    
    if ($password === $correctPassword) {
        session(['authenticated' => true]);
        return redirect('/');
    }
    
    return back()->withErrors(['password' => 'Password salah!']);
})->name('login');
