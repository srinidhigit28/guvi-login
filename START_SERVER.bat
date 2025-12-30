@echo off
echo ========================================
echo  GUVI Project - Starting PHP Server
echo ========================================
echo.
echo Server will start at: http://localhost:8000
echo.
echo IMPORTANT: Keep this window open while using the site!
echo Press Ctrl+C to stop the server
echo.
echo ========================================
echo.

cd /d "%~dp0"
start http://localhost:8000
php -S localhost:8000

pause
