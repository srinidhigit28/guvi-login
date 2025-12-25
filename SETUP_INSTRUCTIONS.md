# GUVI Internship - Setup Guide

## Fixes Applied

### 1. login.php
- ✅ Added CORS headers for AJAX requests
- ✅ Fixed JSON input handling (now supports both JSON and form data)
- ✅ Proper error handling

### 2. profile.php
- ✅ Added MongoDB autoloader requirement
- ✅ Added CORS headers for AJAX requests
- ✅ Fixed JSON input handling for both get and update actions
- ✅ Fixed input array references in update action

## Installation Requirements

### 1. MySQL Database
```bash
# Import the database schema
mysql -u root -p < database.sql
```

Or manually in MySQL:
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

### 2. MongoDB
- Install MongoDB: https://www.mongodb.com/try/download/community
- Start MongoDB service:
  ```bash
  # Windows
  net start MongoDB
  
  # Linux/Mac
  sudo systemctl start mongod
  ```
- MongoDB will auto-create database `guvi_internship` and collection `profiles`

### 3. Redis
- Install Redis: https://redis.io/download
- Start Redis service:
  ```bash
  # Windows (using WSL or Redis for Windows)
  redis-server
  
  # Linux/Mac
  sudo systemctl start redis
  ```

### 4. PHP Extensions

#### Install Redis Extension
```bash
# Using PECL
pecl install redis

# Or on Ubuntu/Debian
sudo apt-get install php-redis

# On Windows with XAMPP/WAMP
# Download php_redis.dll and add to php.ini:
extension=php_redis.dll
```

#### Install MongoDB Extension
```bash
# Using PECL
pecl install mongodb

# Or on Ubuntu/Debian
sudo apt-get install php-mongodb

# On Windows with XAMPP/WAMP
# Download php_mongodb.dll and add to php.ini:
extension=php_mongodb.dll
```

### 5. Install MongoDB PHP Library via Composer
```bash
# Navigate to project root
cd "d:\SRINIDHI DOCUMENT\login guvi"

# Install composer dependencies
composer install
```

If you don't have Composer:
```bash
# Download and install Composer
# Windows: https://getcomposer.org/Composer-Setup.exe
# Linux/Mac:
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

## Verify PHP Extensions

Create a file `phpinfo.php`:
```php
<?php phpinfo(); ?>
```

Open in browser and search for:
- ✅ **redis** section
- ✅ **mongodb** section

## Configuration

If your database credentials differ, edit these files:

### MySQL (login.php, register.php)
```php
$host = 'localhost';
$username = 'root';
$password_db = ''; // Your MySQL password
$database = 'guvi_internship';
```

### Redis (login.php, profile.php)
```php
$redis->connect('localhost', 6379);
```

### MongoDB (profile.php)
```php
$mongoUri = 'mongodb://localhost:27017';
```

## Testing

1. **Start your web server** (Apache/XAMPP/WAMP)
2. **Navigate to**: `http://localhost/login guvi/index.html`
3. **Register** a new account
4. **Login** with your credentials
5. **Update profile** with age, DOB, and contact

## Common Issues

### "MongoDB connection failed"
- Install composer: `composer install`
- Install MongoDB PHP extension: `pecl install mongodb`
- Enable in php.ini: `extension=mongodb.so` (Linux) or `extension=php_mongodb.dll` (Windows)

### "Redis connection failed"
- Install Redis server
- Start Redis: `redis-server`
- Install PHP Redis extension: `pecl install redis`
- Enable in php.ini: `extension=redis.so` (Linux) or `extension=php_redis.dll` (Windows)

### "Database connection failed"
- Check MySQL is running
- Verify credentials in PHP files
- Import database.sql schema

### AJAX errors
- Check browser console (F12)
- Verify CORS headers are present
- Check PHP error log for backend errors

## Project Structure
```
login guvi/
├── assets/
├── css/
│   └── style.css
├── js/
│   ├── register.js
│   ├── login.js
│   └── profile.js
├── php/
│   ├── register.php
│   ├── login.php
│   └── profile.php
├── vendor/              # Created by composer
│   └── mongodb/
├── index.html
├── register.html
├── login.html
├── profile.html
├── database.sql         # MySQL schema
└── composer.json        # PHP dependencies
```

## Technology Stack
- **Frontend**: HTML5, CSS3, Bootstrap 5, jQuery 3.6.4
- **Backend**: PHP 7.4+ 
- **Databases**: MySQL 8.0, MongoDB 5.0+, Redis 6.0+
- **Communication**: jQuery AJAX (JSON)
