# TROUBLESHOOTING: 405 Method Not Allowed

## ✅ Issues Found & Solutions

### Issue 1: Tracking Prevention (Browser)
**Error:** `Tracking Prevention blocked access to storage for CDN`
**Solution:** This is just a browser warning - IGNORE IT. It doesn't affect functionality.

### Issue 2: 405 Method Not Allowed
**Error:** `Failed to load resource: the server responded with a status of 405`
**Cause:** PHP server might not be running in the correct directory

---

## 🔧 COMPLETE FIX - RUN THESE COMMANDS

### Step 1: Stop Current PHP Server
```powershell
Get-Process | Where-Object {$_.ProcessName -eq "php"} | Stop-Process -Force
```

### Step 2: Navigate to Project Directory
```powershell
cd "d:\SRINIDHI DOCUMENT\login guvi"
```

### Step 3: Start PHP Server Correctly
```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```

**Keep this terminal open!**

### Step 4: Test in Browser
Open: `http://localhost:8000/register.html`

---

## ✅ VERIFICATION CHECKLIST

Run these commands to verify everything:

### 1. Check MySQL is Running
```powershell
netstat -ano | findstr :3306
```
Should show output (MySQL running on port 3306)

### 2. Check PHP Server is Running
```powershell
netstat -ano | findstr :8000
```
Should show output (PHP running on port 8000)

### 3. Check MongoDB is Running (if installed)
```powershell
netstat -ano | findstr :27017
```
Should show output (MongoDB running on port 27017)

### 4. Check Redis is Running (if installed)
```powershell
netstat -ano | findstr :6379
```
Should show output (Redis running on port 6379)

---

## 🚀 FULL STARTUP SEQUENCE (4 Terminals)

### Terminal 1: MySQL
```powershell
& "C:\xampp\mysql\bin\mysqld.exe" --console
```

### Terminal 2: MongoDB
```powershell
& "C:\Program Files\MongoDB\Server\7.0\bin\mongod.exe" --dbpath="C:\data\db"
```

### Terminal 3: Redis
```powershell
& "C:\Program Files\Redis\redis-server.exe"
```

### Terminal 4: PHP Server
```powershell
cd "d:\SRINIDHI DOCUMENT\login guvi"
& "C:\xampp\php\php.exe" -S localhost:8000
```

---

## 🎯 QUICK TEST

After all services running, open browser:
```
http://localhost:8000/register.html
```

Fill form:
- Email: test@example.com
- Password: password123
- Confirm: password123

Click **Register** → Should show success message

---

## ⚠️ Common Issues

### "Cannot connect to MySQL"
- Make sure Terminal 1 (MySQL) is running
- Check: `netstat -ano | findstr :3306`

### "405 Method Not Allowed"
- Make sure you're accessing via `http://localhost:8000` (not file://)
- Make sure PHP server is running in project root

### "MongoDB connection failed"
- Make sure Terminal 2 (MongoDB) is running
- Check: `netstat -ano | findstr :27017`

### "Redis connection failed"
- Make sure Terminal 3 (Redis) is running
- Check: `netstat -ano | findstr :6379`

---

## 📱 Browser Console Errors to IGNORE

These are safe to ignore:
- ✅ "Tracking Prevention blocked access to storage"
- ✅ CDN warnings
- ✅ Cookie warnings

These need fixing:
- ❌ "405 Method Not Allowed"
- ❌ "500 Internal Server Error"
- ❌ "Cannot connect to database"
