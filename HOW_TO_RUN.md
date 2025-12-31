# 🚀 GUVI Project - Quick Start Guide

## ⚡ QUICK START (Easy Way)

**Just double-click:** `START_PROJECT.bat`

This single file will:
- ✅ Fix MySQL port conflicts automatically
- ✅ Start PHP development server
- ✅ Open your browser to the project
- ✅ Everything works!

---

## ⚠️ STOP! READ THIS FIRST ⚠️

**NEVER open .html files directly by double-clicking them!**

This will cause **500 Internal Server Error** because PHP backend won't work.

---

## ✅ How to Run Your Project (CORRECT WAY)

### Step 1: Start the Server
**Double-click this file:**
```
START_SERVER.bat
```

This will:
- Start PHP development server on port 8000
- Automatically open your browser
- Keep a command window open (DON'T CLOSE IT!)

### Step 2: Access Your Site
Your browser will open automatically to:
```
http://localhost:8000
```

**OR manually visit these URLs:**
- 🏠 Home: http://localhost:8000/
- 📝 Register: http://localhost:8000/register.html  
- 🔐 Login: http://localhost:8000/login.html
- 👤 Profile: http://localhost:8000/profile.html

---

## 🛑 Common Mistakes (AVOID THESE!)

❌ **WRONG:** Double-clicking `index.html` or `register.html`
   - This opens as `file:///D:/...` ← **THIS CAUSES ERRORS!**

✅ **CORRECT:** Run `START_SERVER.bat` then visit `http://localhost:8000`

---

## 🔧 If You Get Errors

### "500 Internal Server Error"
**Cause:** You opened the file directly, not through the PHP server

**Fix:**
1. Close the browser tab
2. Run `START_SERVER.bat`
3. Visit http://localhost:8000

### "Failed to load resource"
**Cause:** PHP server is not running

**Fix:**
1. Run `START_SERVER.bat`
2. Keep the command window open
3. Refresh your browser

### "Port 8000 already in use"
**Cause:** Server is already running

**Fix:**
1. Find the existing command window and close it
2. OR change port in START_SERVER.bat (change 8000 to 8001)
3. Run START_SERVER.bat again

### "MySQL Port 3306 in use" (XAMPP Error)
**Cause:** MySQL is already running and blocking XAMPP

**PERMANENT FIX:**
1. **Double-click `FIX_MYSQL_PORT.bat`** (in project folder)
2. This will stop conflicting MySQL processes
3. Then start MySQL from XAMPP Control Panel
4. MySQL will start successfully

**OR use the complete startup:**
1. **Double-click `START_PROJECT.bat`**
2. This automatically fixes MySQL and starts everything

---

## 📌 Remember

1. **Always use START_SERVER.bat**
2. **Always access via http://localhost:8000**
3. **Keep server window open while working**
4. **Press Ctrl+C in server window to stop**

---

## ✅ GUVI Compliance Checklist

- AJAX-only; all requests use `$.ajax` with `type: 'POST'`
- No php://input or JSON decode on request bodies; `$_POST` only
- Prepared statements in PHP for MySQL queries
- No PHP sessions; tokens stored in localStorage; Redis stub for server-side session data
- No CORS headers added; same-origin only
- Password rule enforced client-side: min 6 chars, includes capital letter, number, special character
- Form field names/IDs unchanged (registerEmail, registerPassword, registerConfirmPassword, loginEmail, loginPassword)

---

## 🌐 Live Sites

- **AWS EC2:** http://100.48.79.82/
- **GitHub:** https://github.com/srinidhigit28/guvi-login

---

## 🆘 Still Having Issues?

Make sure:
- ✅ XAMPP MySQL is running (for database)
- ✅ PHP is installed (check: `php --version`)
- ✅ You're in the project folder
- ✅ No other program is using port 8000
