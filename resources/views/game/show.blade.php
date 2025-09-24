<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tic Tac Toe - {{ $game->player_x_name }} vs {{ $game->player_o_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 20px;
        }

        .game-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .players-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 15px;
        }

        .player {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .player.active {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .player-name {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .player-symbol {
            font-size: 2rem;
            font-weight: bold;
        }

        .game-status {
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            font-weight: 600;
        }

        .game-status.winner {
            background: linear-gradient(45deg, #00b894, #00cec9);
            animation: pulse 2s infinite;
        }

        .game-status.draw {
            background: linear-gradient(45deg, #fdcb6e, #e17055);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .game-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            max-width: 300px;
            margin: 0 auto 30px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 20px;
        }

        .cell {
            aspect-ratio: 1;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 15px;
            font-size: 3rem;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .cell:hover:not(.filled) {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cell.filled {
            cursor: not-allowed;
            background: rgba(255, 255, 255, 0.3);
        }

        .cell.x {
            color: #ff6b6b;
        }

        .cell.o {
            color: #4ecdc4;
        }

        .cell.winning {
            background: linear-gradient(45deg, #00b894, #00cec9);
            animation: winning-cell 1s ease-in-out;
        }

        @keyframes winning-cell {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .game-controls {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .btn.secondary {
            background: linear-gradient(45deg, #74b9ff, #0984e3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .loading {
            display: none;
            margin: 20px 0;
        }

        .spinner {
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .game-container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .players-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .cell {
                font-size: 2.5rem;
            }
            
            .game-controls {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>🎮 Tic Tac Toe</h1>
        
        <div class="players-info">
            <div class="player" id="playerX">
                <div class="player-name">{{ $game->player_x_name }}</div>
                <div class="player-symbol x">❌</div>
            </div>
            <div class="player" id="playerO">
                <div class="player-name">{{ $game->player_o_name }}</div>
                <div class="player-symbol o">⭕</div>
            </div>
        </div>

        <div class="game-status" id="gameStatus">
            @if($game->is_finished)
                @if($game->winner === 'draw')
                    🤝 Permainan Seri!
                @else
                    🎉 {{ $game->winner === 'X' ? $game->player_x_name : $game->player_o_name }} Menang!
                @endif
            @else
                🎯 Giliran: {{ $game->current_player === 'X' ? $game->player_x_name : $game->player_o_name }}
            @endif
        </div>

        <div class="game-board" id="gameBoard">
            @for($i = 0; $i < 9; $i++)
                <button class="cell" data-position="{{ $i }}" onclick="makeMove({{ $i }})">
                    @if($game->board[$i] !== '')
                        {{ $game->board[$i] === 'X' ? '❌' : '⭕' }}
                    @endif
                </button>
            @endfor
        </div>

        <div class="game-controls">
            <button class="btn" onclick="resetGame()">🔄 Reset Game</button>
            <button class="btn secondary" onclick="newGame()">🆕 Game Baru</button>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Memproses...</p>
        </div>

        <div class="error-message" id="errorMessage"></div>
    </div>

    <script>
        const gameId = {{ $game->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let gameData = @json($game);

        function updateGameState(newGameData) {
            gameData = newGameData;
            updateUI();
        }

        function updateUI() {
            // Update board
            const cells = document.querySelectorAll('.cell');
            cells.forEach((cell, index) => {
                const value = gameData.board[index];
                if (value === 'X') {
                    cell.textContent = '❌';
                    cell.classList.add('filled', 'x');
                } else if (value === 'O') {
                    cell.textContent = '⭕';
                    cell.classList.add('filled', 'o');
                } else {
                    cell.textContent = '';
                    cell.classList.remove('filled', 'x', 'o');
                }
            });

            // Update current player highlight
            document.getElementById('playerX').classList.toggle('active', gameData.current_player === 'X' && !gameData.is_finished);
            document.getElementById('playerO').classList.toggle('active', gameData.current_player === 'O' && !gameData.is_finished);

            // Update game status
            const statusElement = document.getElementById('gameStatus');
            statusElement.classList.remove('winner', 'draw');
            
            if (gameData.is_finished) {
                if (gameData.winner === 'draw') {
                    statusElement.textContent = '🤝 Permainan Seri!';
                    statusElement.classList.add('draw');
                } else {
                    const winnerName = gameData.winner === 'X' ? gameData.player_x_name : gameData.player_o_name;
                    statusElement.textContent = `🎉 ${winnerName} Menang!`;
                    statusElement.classList.add('winner');
                }
            } else {
                const currentPlayerName = gameData.current_player === 'X' ? gameData.player_x_name : gameData.player_o_name;
                statusElement.textContent = `🎯 Giliran: ${currentPlayerName}`;
            }
        }

        function showLoading() {
            document.getElementById('loading').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        async function makeMove(position) {
            if (gameData.is_finished || gameData.board[position] !== '') {
                return;
            }

            showLoading();

            try {
                const response = await fetch(`/api/game/${gameId}/move`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ position })
                });

                const data = await response.json();

                if (data.success) {
                    updateGameState(data.game);
                } else {
                    showError(data.message || 'Gagal melakukan move');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                hideLoading();
            }
        }

        async function resetGame() {
            showLoading();

            try {
                const response = await fetch(`/api/game/${gameId}/reset`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    updateGameState(data.game);
                } else {
                    showError('Gagal mereset game');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                hideLoading();
            }
        }

        function newGame() {
            window.location.href = '/';
        }

        // Initialize UI
        updateUI();

        // Auto-refresh game state every 5 seconds (for multiplayer scenarios)
        setInterval(async () => {
            try {
                const response = await fetch(`/api/game/${gameId}`);
                const data = await response.json();
                updateGameState(data);
            } catch (error) {
                console.error('Error refreshing game state:', error);
            }
        }, 5000);
    </script>
</body>
</html>