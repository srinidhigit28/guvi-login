@echo off
echo ========================================
echo  MYSQL PORT 3306 CONFLICT FIX
echo ========================================
echo.
echo This will stop any MySQL process using port 3306
echo.

REM Stop any running MySQL processes
echo [1/3] Stopping MySQL processes...
taskkill /F /IM mysqld.exe >nul 2>&1
if %errorlevel% == 0 (
    echo   SUCCESS: MySQL processes stopped
) else (
    echo   INFO: No MySQL processes were running
)

REM Wait a moment
timeout /t 2 /nobreak >nul

REM Check if port is now free
echo.
echo [2/3] Checking port 3306...
netstat -ano | findstr ":3306" >nul
if %errorlevel% == 0 (
    echo   WARNING: Port 3306 still in use. Trying again...
    taskkill /F /IM mysqld.exe >nul 2>&1
    timeout /t 2 /nobreak >nul
) else (
    echo   SUCCESS: Port 3306 is now free
)

echo.
echo [3/3] Port 3306 is ready for XAMPP MySQL
echo.
echo ========================================
echo  NEXT STEPS:
echo ========================================
echo 1. Open XAMPP Control Panel
echo 2. Click START next to MySQL
echo 3. MySQL should start successfully now
echo.
echo TIP: Always use this script before starting
echo      XAMPP MySQL if you see port conflicts
echo ========================================
echo.
pause
