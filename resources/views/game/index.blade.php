<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tic Tac Toe - Game Seru!</title>
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
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            max-width: 500px;
            width: 90%;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .game-setup {
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        input[type="text"]:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
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
            background: linear-gradient(45deg, #ee5a24, #ff6b6b);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .loading {
            display: none;
            margin-top: 20px;
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

        .error-message {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .game-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎮 Tic Tac Toe</h1>
        <p class="subtitle">Game klasik yang tak pernah membosankan!</p>
        
        <div class="game-setup">
            <div class="input-group">
                <label for="playerX">Nama Player X:</label>
                <input type="text" id="playerX" placeholder="Masukkan nama Player X" value="Player X">
            </div>
            
            <div class="input-group">
                <label for="playerO">Nama Player O:</label>
                <input type="text" id="playerO" placeholder="Masukkan nama Player O" value="Player O">
            </div>
            
            <button class="btn" onclick="startNewGame()">🚀 Mulai Game Baru</button>
            
            <div class="loading">
                <div class="spinner"></div>
                <p>Mempersiapkan game...</p>
            </div>
            
            <div class="error-message" id="errorMessage"></div>
        </div>

        <div class="game-info">
            <h3>📋 Cara Bermain:</h3>
            <p>• Player X selalu mulai duluan</p>
            <p>• Klik kotak kosong untuk menempatkan simbol</p>
            <p>• Menangkan dengan membuat 3 simbol berjajar</p>
            <p>• Horizontal, vertikal, atau diagonal!</p>
        </div>
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function showLoading() {
            document.querySelector('.loading').style.display = 'block';
            document.querySelector('.btn').disabled = true;
        }
        
        function hideLoading() {
            document.querySelector('.loading').style.display = 'none';
            document.querySelector('.btn').disabled = false;
        }
        
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }
        
        async function startNewGame() {
            const playerXName = document.getElementById('playerX').value.trim() || 'Player X';
            const playerOName = document.getElementById('playerO').value.trim() || 'Player O';
            
            showLoading();
            
            try {
                const response = await fetch('/api/game/new', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        player_x_name: playerXName,
                        player_o_name: playerOName
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Redirect to game page
                    window.location.href = `/game/${data.game.id}`;
                } else {
                    showError('Gagal membuat game baru. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                hideLoading();
            }
        }
        
        // Allow Enter key to start game
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                startNewGame();
            }
        });
    </script>
</body>
</html>