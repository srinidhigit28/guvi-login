# GUVI Internship - Terminal Setup Commands

## Step 1: Navigate to Project Directory
cd "d:\SRINIDHI DOCUMENT\login guvi"

## Step 2: Verify PHP Version and Extensions
php --version
php -m | findstr /i "mongodb redis mysqli"

## Step 3: Check PHP Configuration
php --ini

## Step 4: Create MySQL Database
# Option A: Via PowerShell (if MySQL is installed)
mysql -u root -p < database.sql

# Option B: Manual import via MySQL command line
# 1. Open MySQL Command Line Client
# 2. Run commands:
# CREATE DATABASE guvi_internship;
# USE guvi_internship;
# (Import database.sql content)

## Step 5: Verify MySQL Database Created
mysql -u root -p -e "USE guvi_internship; SHOW TABLES;"

## Step 6: Start Services (if not already running)

### MySQL (XAMPP)
# Already running in XAMPP Control Panel, or:
"C:\xampp\mysql\bin\mysqld.exe"

### MongoDB
# Start MongoDB service
mongod --dbpath="C:\data\db"

# OR if MongoDB is installed as a service
net start MongoDB

### Redis
# Start Redis service
redis-server

## Step 7: Start PHP Development Server
php -S localhost:8000

## Step 8: Access Application
# In Browser:
# http://localhost:8000/index.html
# OR
# http://localhost:8000/register.html

## Step 9: Test Registration Flow
1. Open http://localhost:8000/register.html
2. Enter email: test@example.com
3. Enter password: password123
4. Click Register

## Step 10: Test Login Flow
1. Open http://localhost:8000/login.html
2. Enter same credentials
3. Should redirect to profile.html

## Step 11: Test Profile Update
1. Should be on profile.html after login
2. Click "Edit Profile"
3. Enter Age, DOB, Contact
4. Click "Save Changes"

## Troubleshooting Commands

### Check PHP Extensions
php -i | findstr /i "mysqli"
php -i | findstr /i "mongodb"
php -i | findstr /i "redis"

### Check MySQL Connection
mysql -u root -p -h localhost

### Check MongoDB Connection
mongosh

### Check Redis Connection
redis-cli ping

### View PHP Error Log
type C:\xampp\php\logs\php_error_log

### Check XAMPP Status
netstat -ano | findstr :3306
netstat -ano | findstr :27017
netstat -ano | findstr :6379
netstat -ano | findstr :8000

### Kill Process on Port
netstat -ano | findstr :8000
taskkill /PID <PID> /F

## Quick Start Script (All in One)

# Run this for complete setup:
cd "d:\SRINIDHI DOCUMENT\login guvi"
php -S localhost:8000

# Then in another PowerShell window:
# Start MongoDB:
mongod --dbpath="C:\data\db"

# In another PowerShell window:
# Start Redis:
redis-server

# In Browser:
# http://localhost:8000/register.html
