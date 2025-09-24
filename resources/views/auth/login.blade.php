<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Login - Tic Tac Toe Game</title>
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
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .game-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fcc;
            display: none;
        }

        .password-hint {
            background: #e8f4fd;
            color: #0066cc;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 0.9rem;
            border: 1px solid #b3d9ff;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .game-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <span class="game-icon">🎮</span>
        <h1>Tic Tac Toe Game</h1>
        <p class="subtitle">Masukkan password untuk mengakses game</p>
        
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="password">🔑 Password Game:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password untuk akses game" required>
            </div>
            
            @if($errors->has('password'))
                <div class="error-message">
                    {{ $errors->first('password') }}
                </div>
            @endif
            
            <button type="submit" class="login-btn">
                🚀 Masuk ke Game
            </button>
        </form>

        <div class="password-hint">
            💡 <strong>Hint:</strong> Password default adalah "tictactoe123"
        </div>
    </div>

    <script>
        // Simple form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            
            if (!password.trim()) {
                e.preventDefault();
                alert('Silakan masukkan password!');
            }
        });
    </script>
</body>
</html>