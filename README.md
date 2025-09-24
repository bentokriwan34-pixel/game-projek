# 🎮 Laravel Tic-Tac-Toe Game

**Game paling seru** - Permainan Tic-Tac-Toe klasik yang dibangun dengan Laravel 12!

## ✨ Fitur Utama

- 🎯 **Gameplay Klasik**: Permainan Tic-Tac-Toe tradisional dengan UI modern
- 👥 **Multiplayer**: Dua pemain dapat bermain dengan nama custom
- 🎨 **UI Menarik**: Desain modern dengan gradien warna yang indah
- 📱 **Responsive**: Dapat dimainkan di desktop dan mobile
- ⚡ **Real-time**: Update permainan secara langsung tanpa refresh
- 🔄 **Reset Game**: Fitur untuk mengulang permainan
- 🏆 **Deteksi Pemenang**: Otomatis mendeteksi pemenang dan draw
- 💾 **Persistent**: Data game tersimpan di database SQLite

## 🚀 Cara Menjalankan

1. Clone repository ini
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Generate app key: `php artisan key:generate`
5. Jalankan migrasi: `php artisan migrate`
6. Start server: `php artisan serve`
7. Buka browser ke `http://127.0.0.1:8000`

## 🎯 Cara Bermain

1. Masukkan nama Player X dan Player O
2. Klik "🚀 Mulai Game Baru"
3. Player X selalu mulai duluan
4. Klik kotak kosong untuk menempatkan simbol
5. Menangkan dengan membuat 3 simbol berjajar (horizontal, vertikal, atau diagonal)

## 🛠️ Teknologi

- **Backend**: Laravel 12
- **Database**: SQLite
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Styling**: CSS Grid, Flexbox, Gradients

## 📝 License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
