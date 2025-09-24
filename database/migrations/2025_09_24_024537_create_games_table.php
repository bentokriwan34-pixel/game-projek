<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->json('board')->default('["","","","","","","","",""]'); // 3x3 board state
            $table->string('current_player')->default('X'); // X or O
            $table->string('winner')->nullable(); // X, O, or draw
            $table->boolean('is_finished')->default(false);
            $table->string('player_x_name')->default('Player X');
            $table->string('player_o_name')->default('Player O');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
