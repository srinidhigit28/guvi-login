@echo off
echo ========================================
echo  GUVI PROJECT - COMPLETE STARTUP
echo ========================================
echo.

REM Step 1: Fix MySQL port conflict
echo [Step 1/3] Fixing MySQL port conflicts...
taskkill /F /IM mysqld.exe >nul 2>&1
timeout /t 2 /nobreak >nul
echo   MySQL processes cleared

REM Step 2: Check if XAMPP MySQL is running
echo.
echo [Step 2/3] Checking XAMPP MySQL status...
netstat -ano | findstr ":3306" >nul
if %errorlevel% == 0 (
    echo   MySQL is running on port 3306
) else (
    echo   WARNING: MySQL is NOT running!
    echo   Please start MySQL from XAMPP Control Panel
    echo.
    echo   Opening XAMPP Control Panel...
    start "" "C:\xampp\xampp-control.exe"
    echo.
    echo   After MySQL starts in XAMPP, press any key to continue...
    pause >nul
)

REM Step 3: Start PHP development server
echo.
echo [Step 3/3] Starting PHP development server...
echo   Server URL: http://localhost:8000
echo.
echo ========================================
echo  GUVI PROJECT IS READY!
echo ========================================
echo.
echo  Home Page: http://localhost:8000
echo  Register:  http://localhost:8000/register.html
echo  Login:     http://localhost:8000/login.html
echo  Profile:   http://localhost:8000/profile.html
echo.
echo  IMPORTANT: Keep this window open!
echo  Press Ctrl+C to stop the server
echo ========================================
echo.

cd /d "%~dp0"
start http://localhost:8000
php -S localhost:8000
