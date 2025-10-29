@echo off
echo ========================================
echo    POS KASIR - AUTO SETUP SCRIPT
echo ========================================
echo.

echo [1/5] Membersihkan Cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo ✓ Cache dibersihkan

echo.
echo [2/5] Memeriksa koneksi database...
php artisan db:show 2>nul
if errorlevel 1 (
    echo ✗ GAGAL: MySQL tidak berjalan!
    echo.
    echo SOLUSI:
    echo 1. Buka XAMPP Control Panel
    echo 2. Klik START pada MySQL
    echo 3. Jalankan script ini lagi
    echo.
    pause
    exit /b 1
)
echo ✓ Database terkoneksi

echo.
echo [3/5] Menjalankan migrasi database...
php artisan migrate --force
if errorlevel 1 (
    echo ✗ Migrasi gagal!
    echo Coba jalankan: php artisan migrate:fresh
    pause
    exit /b 1
)
echo ✓ Migrasi berhasil

echo.
echo [4/5] Mengisi data awal (seeder)...
php artisan db:seed --class=CategoryProductSeeder --force
echo ✓ Data awal berhasil diisi

echo.
echo [5/5] Setup selesai!
echo.
echo ========================================
echo    APLIKASI SIAP DIGUNAKAN!
echo ========================================
echo.
echo Jalankan server dengan:
echo   php artisan serve
echo.
echo Lalu buka browser:
echo   http://127.0.0.1:8000
echo.
echo Login Admin:
echo   Email: hafizadmin@mail.com
echo   Password: Hafiz123
echo.
echo Login Kasir:
echo   Email: hafizkasir@mail.com
echo   Password: Hafiz123
echo.
pause
