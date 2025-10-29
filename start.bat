@echo off
echo ========================================
echo    MENJALANKAN POS KASIR SERVER
echo ========================================
echo.

echo Memeriksa XAMPP MySQL...
netstat -ano | findstr :3306 >nul
if errorlevel 1 (
    echo ✗ MySQL tidak berjalan!
    echo.
    echo SOLUSI:
    echo 1. Buka XAMPP Control Panel
    echo 2. Klik START pada MySQL
    echo 3. Jalankan script ini lagi
    echo.
    pause
    exit /b 1
)

echo ✓ MySQL berjalan
echo.
echo Starting Laravel development server...
echo.
echo ========================================
echo  Server: http://127.0.0.1:8000
echo  Tekan Ctrl+C untuk stop server
echo ========================================
echo.

php artisan serve
