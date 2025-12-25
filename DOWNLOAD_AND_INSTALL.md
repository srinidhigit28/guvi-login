# GUVI Internship - Complete Installation Guide (Option B: With Redis)

## 📥 Step-by-Step Downloads & Installation

### Step 1: XAMPP (Already Downloaded ✓)
**Status:** Already have installer
```
Location: C:\Users\Admin\Downloads\xampp-windows-x64-8.1.25-0-VS16-installer.exe
```

**Installation Steps:**
1. Run the installer
2. Accept all defaults
3. Install to: `C:\xampp`
4. Select components: Apache, MySQL, PHP
5. Click Install

**After Installation:**
```
✓ MySQL will be at: C:\xampp\mysql
✓ PHP will be at: C:\xampp\
✓ Apache will be at: C:\xampp\apache
```

---

### Step 2: MongoDB Server (MUST DOWNLOAD)
**Download Link:** https://www.mongodb.com/try/download/community

**Steps:**
1. Go to: https://www.mongodb.com/try/download/community
2. Select:
   - **Version:** Latest (7.0 or 8.0)
   - **OS:** Windows
   - **Package:** MSI
3. Click **Download**
4. Save to: `C:\Users\Admin\Downloads\`
5. Double-click the `.msi` file
6. Click Next → Accept License → Install
7. Install to default: `C:\Program Files\MongoDB\Server\X.X`

**After Installation:**
```
mongod.exe will be at: C:\Program Files\MongoDB\Server\7.0\bin\mongod.exe
```

---

### Step 3: Redis for Windows (MUST DOWNLOAD)
**Download Link:** https://github.com/microsoftarchive/redis/releases

**Steps:**
1. Go to: https://github.com/microsoftarchive/redis/releases
2. Find latest version (look for `Redis-x64-...` or `Redis-x86-...`)
3. Download: **Redis-x64-3.2.100.msi** (or latest)
4. Save to: `C:\Users\Admin\Downloads\`
5. Double-click the `.msi` file
6. Accept defaults
7. Install to default: `C:\Program Files\Redis`

**After Installation:**
```
redis-server.exe will be at: C:\Program Files\Redis\redis-server.exe
```

---

## ✅ Verification - After All Installations

### Verify XAMPP
```powershell
# Check if PHP works
C:\xampp\php\php.exe -v

# Check if MySQL exists
C:\xampp\mysql\bin\mysql.exe --version
```

### Verify MongoDB
```powershell
# Check if mongod exists
& "C:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --version
```

### Verify Redis
```powershell
# Check if redis-server exists
& "C:\Program Files\Redis\redis-server.exe" --version
```

---

## 🚀 Start All Services (Final Setup)

Create a file: `START_ALL_SERVICES.ps1`

```powershell
# Start XAMPP Services
Write-Host "Starting MySQL..." -ForegroundColor Green
& "C:\xampp\mysql\bin\mysqld.exe" &

Write-Host "Starting MongoDB..." -ForegroundColor Green
& "C:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --dbpath="C:\data\db" &

Write-Host "Starting Redis..." -ForegroundColor Green
& "C:\Program Files\Redis\redis-server.exe" &

Start-Sleep -Seconds 3

Write-Host "Starting PHP Development Server..." -ForegroundColor Green
cd "d:\SRINIDHI DOCUMENT\login guvi"
& "C:\xampp\php\php.exe" -S localhost:8000

Write-Host "All services started!" -ForegroundColor Cyan
Write-Host "Access application at: http://localhost:8000/register.html" -ForegroundColor Cyan
```

---

## 📋 Download Checklist

```
□ XAMPP - Already Downloaded ✓
  Location: C:\Users\Admin\Downloads\xampp-windows-x64-8.1.25-0-VS16-installer.exe

□ MongoDB - DOWNLOAD NOW
  Link: https://www.mongodb.com/try/download/community
  File: mongodb-windows-x64-X.X.X.msi

□ Redis - DOWNLOAD NOW  
  Link: https://github.com/microsoftarchive/redis/releases
  File: Redis-x64-3.2.100.msi (or latest)

□ PHP - INCLUDED IN XAMPP ✓

□ MySQL - INCLUDED IN XAMPP ✓
```

---

## 🔧 Final Configuration

After installing all three, run these terminal commands:

```powershell
# 1. Create MySQL database
"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS guvi_internship;"

# 2. Create users table
"C:\xampp\mysql\bin\mysql.exe" -u root guvi_internship < "d:\SRINIDHI DOCUMENT\login guvi\setup.sql"

# 3. Test MongoDB connection
& "C:\Program Files\MongoDB\Server\7.0\bin\mongosh.exe"
# Type: exit

# 4. Test Redis connection
& "C:\Program Files\Redis\redis-cli.exe"
# Type: ping (should return PONG)
# Type: exit
```

---

## ⚡ Quick Terminal Commands (Copy & Paste)

### Terminal 1: Start MySQL
```powershell
"C:\xampp\mysql\bin\mysqld.exe"
```

### Terminal 2: Start MongoDB
```powershell
& "C:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --dbpath="C:\data\db"
```

### Terminal 3: Start Redis
```powershell
& "C:\Program Files\Redis\redis-server.exe"
```

### Terminal 4: Start PHP Server
```powershell
cd "d:\SRINIDHI DOCUMENT\login guvi"
"C:\xampp\php\php.exe" -S localhost:8000
```

### Terminal 5: Access Application
Open in Browser: `http://localhost:8000/register.html`

---

## ✨ That's It!

Once all services are running:
1. Open: `http://localhost:8000/register.html`
2. Register new account
3. Login
4. View & Update Profile

**All data will be stored in:**
- MySQL (auth data)
- MongoDB (profiles)
- Redis (sessions)
