<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'board',
        'current_player',
        'winner',
        'is_finished',
        'player_x_name',
        'player_o_name'
    ];

    protected $casts = [
        'board' => 'array',
        'is_finished' => 'boolean'
    ];

    public function makeMove($position, $player)
    {
        $board = $this->board;
        
        // Check if position is valid and empty
        if ($position < 0 || $position > 8 || $board[$position] !== '') {
            return false;
        }

        // Make the move
        $board[$position] = $player;
        $this->board = $board;

        // Check for winner
        $winner = $this->checkWinner($board);
        if ($winner) {
            $this->winner = $winner;
            $this->is_finished = true;
        } elseif (!in_array('', $board)) {
            // Board is full, it's a draw
            $this->winner = 'draw';
            $this->is_finished = true;
        } else {
            // Switch player
            $this->current_player = $player === 'X' ? 'O' : 'X';
        }

        $this->save();
        return true;
    }

    private function checkWinner($board)
    {
        // Winning combinations
        $winningCombinations = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // columns
            [0, 4, 8], [2, 4, 6] // diagonals
        ];

        foreach ($winningCombinations as $combination) {
            [$a, $b, $c] = $combination;
            if ($board[$a] !== '' && $board[$a] === $board[$b] && $board[$b] === $board[$c]) {
                return $board[$a];
            }
        }

        return null;
    }

    public function resetGame()
    {
        $this->board = ['', '', '', '', '', '', '', '', ''];
        $this->current_player = 'X';
        $this->winner = null;
        $this->is_finished = false;
        $this->save();
    }
}
