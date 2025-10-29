@echo off
title POS KASIR - Quick Start
color 0A

:menu
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║               🏪 POS KASIR - QUICK START MENU               ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo  [1] Setup Database (Jalankan sekali saja)
echo  [2] Start Server (Jalankan web)
echo  [3] Clear Cache
echo  [4] Reset Database (Hapus semua data)
echo  [5] Lihat Credentials Login
echo  [0] Keluar
echo.
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
set /p choice="Pilih menu (0-5): "

if "%choice%"=="1" goto setup
if "%choice%"=="2" goto start
if "%choice%"=="3" goto clear
if "%choice%"=="4" goto reset
if "%choice%"=="5" goto credentials
if "%choice%"=="0" goto exit
goto menu

:setup
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                    🔧 SETUP DATABASE                        ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo [STEP 1] Membersihkan cache...
call php artisan cache:clear
call php artisan config:clear
echo ✓ Cache dibersihkan
echo.
echo [STEP 2] Membuat tabel database...
call php artisan migrate --force
echo ✓ Tabel database dibuat
echo.
echo [STEP 3] Mengisi data awal...
call php artisan db:seed --force
echo ✓ Data berhasil diisi
echo.
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                    ✅ SETUP SELESAI!                        ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo Silakan pilih menu [2] untuk menjalankan server
echo.
pause
goto menu

:start
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                    🚀 STARTING SERVER                       ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo Memeriksa MySQL...
netstat -ano | findstr :3306 >nul
if errorlevel 1 (
    echo ✗ MySQL tidak berjalan!
    echo.
    echo SOLUSI:
    echo 1. Buka XAMPP Control Panel
    echo 2. Klik START pada MySQL
    echo 3. Jalankan menu ini lagi
    echo.
    pause
    goto menu
)
echo ✓ MySQL berjalan
echo.
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
echo  Server: http://127.0.0.1:8000
echo  Tekan Ctrl+C untuk stop server
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
echo.
call php artisan serve
pause
goto menu

:clear
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                    🧹 CLEAR CACHE                           ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
call php artisan cache:clear
call php artisan config:clear
call php artisan view:clear
call php artisan route:clear
echo.
echo ✓ Semua cache berhasil dibersihkan!
echo.
pause
goto menu

:reset
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                    ⚠️  RESET DATABASE                       ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo PERINGATAN: Ini akan menghapus SEMUA data!
echo.
set /p confirm="Ketik 'YA' untuk melanjutkan: "
if not "%confirm%"=="YA" (
    echo.
    echo Reset dibatalkan.
    pause
    goto menu
)
echo.
echo Mereset database...
call php artisan migrate:fresh --seed --force
echo.
echo ✓ Database berhasil direset!
echo ✓ Data awal berhasil diisi kembali
echo.
pause
goto menu

:credentials
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                  🔐 LOGIN CREDENTIALS                       ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo ADMIN:
echo   📧 Email    : hafizadmin@mail.com
echo   🔑 Password : Hafiz123
echo   🌐 URL      : http://127.0.0.1:8000/admin/login
echo.
echo KASIR:
echo   📧 Email    : hafizkasir@mail.com
echo   🔑 Password : Hafiz123
echo   🌐 URL      : http://127.0.0.1:8000/login
echo.
echo USER:
echo   📧 Email    : hafizuser@mail.com
echo   🔑 Password : Hafiz123
echo   🌐 URL      : http://127.0.0.1:8000/login
echo.
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
pause
goto menu

:exit
cls
echo.
echo Terima kasih telah menggunakan POS Kasir!
echo.
timeout /t 2 >nul
exit
