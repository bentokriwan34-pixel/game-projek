<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return view('game.index');
    }

    public function newGame(Request $request)
    {
        $request->validate([
            'player_x_name' => 'nullable|string|max:255',
            'player_o_name' => 'nullable|string|max:255',
        ]);

        $game = Game::create([
            'player_x_name' => $request->player_x_name ?? 'Player X',
            'player_o_name' => $request->player_o_name ?? 'Player O',
        ]);

        return response()->json([
            'success' => true,
            'game' => $game
        ]);
    }

    public function getGame($id)
    {
        $game = Game::findOrFail($id);
        return response()->json($game);
    }

    public function makeMove(Request $request, $id)
    {
        $request->validate([
            'position' => 'required|integer|min:0|max:8',
        ]);

        $game = Game::findOrFail($id);

        if ($game->is_finished) {
            return response()->json([
                'success' => false,
                'message' => 'Game sudah selesai!'
            ], 400);
        }

        $success = $game->makeMove($request->position, $game->current_player);

        if (!$success) {
            return response()->json([
                'success' => false,
                'message' => 'Posisi tidak valid atau sudah terisi!'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'game' => $game->fresh()
        ]);
    }

    public function resetGame($id)
    {
        $game = Game::findOrFail($id);
        $game->resetGame();

        return response()->json([
            'success' => true,
            'game' => $game->fresh()
        ]);
    }

    public function showGame($id)
    {
        $game = Game::findOrFail($id);
        return view('game.show', compact('game'));
    }
}
