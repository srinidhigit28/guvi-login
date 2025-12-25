# GUVI Internship - Quick Start Guide

## ✅ What's Ready

- **PHP Server**: Running on http://localhost:8000 ✓
- **Frontend Files**: All HTML, CSS, JS ready ✓
- **Backend Files**: Register, Login, Profile PHP ready ✓
- **Database Schema**: database.sql ready ✓

## 🔧 What You Need to Do (3 Steps)

### Step 1: Create MySQL Database
```powershell
mysql -u root -p < database.sql
```
**Or manually in MySQL:**
```sql
CREATE DATABASE guvi_internship;
USE guvi_internship;
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Step 2: Start MongoDB (New Terminal)
```powershell
mongod --dbpath="C:\data\db"
```
**Or if installed as service:**
```powershell
net start MongoDB
```

### Step 3: Start Redis (New Terminal)
```powershell
redis-server
```
**Or if installed as service:**
```powershell
net start Redis
```

## 🚀 Access Application

Open in Browser:
```
http://localhost:8000/register.html
```

## 📝 Test Credentials

**Register:**
- Email: test@example.com
- Password: password123

**Login:**
- Same email and password

## 🔍 Test Flow

1. **Register** → Should succeed
2. **Login** → Should redirect to profile
3. **View Profile** → Should show empty profile
4. **Edit Profile** → Fill Age, DOB, Contact
5. **Save** → Should update in MongoDB
6. **Logout** → Should redirect to login

## 🛠️ Troubleshooting

### "Database connection failed"
```powershell
# Verify MySQL is running
mysql -u root -p -e "USE guvi_internship; SHOW TABLES;"
```

### "Redis connection failed"
```powershell
# Check Redis is running
redis-cli ping
# Should return: PONG
```

### "MongoDB connection failed"
```powershell
# Verify MongoDB is running
mongosh
# Should connect successfully
```

### "PHP extensions not found"
```powershell
# Check installed extensions
php -m | findstr /i "mysqli"
php -m | findstr /i "redis"
php -m | findstr /i "mongodb"
```

## 📁 Project Structure

```
login guvi/
├── index.html              ← Welcome page
├── register.html           ← Registration form
├── login.html              ← Login form
├── profile.html            ← Profile page
├── css/style.css
├── js/register.js
├── js/login.js
├── js/profile.js
├── php/register.php
├── php/login.php
├── php/profile.php
├── vendor/autoload.php     ← MongoDB library
├── database.sql
├── composer.json
└── assets/
```

## 💡 How It Works

1. **Frontend** (HTML/CSS/JS) sends data via AJAX to PHP
2. **Register.php** stores email + password in **MySQL**
3. **Login.php** validates user, creates session in **Redis**, returns token
4. **Token** saved in browser localStorage
5. **Profile.php** uses token to validate session via Redis
6. **Profile data** (age, DOB, contact) stored in **MongoDB**

## ✨ Key Features

✓ No form submission (pure AJAX)
✓ GUVI-compliant code (only $_POST, no json_decode)
✓ MySQL for auth (prepared statements)
✓ MongoDB for profiles
✓ Redis for sessions
✓ Bootstrap responsive UI
✓ Beginner-friendly code
