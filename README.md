# GUVI Internship - Portal Connect

A modern, fully-featured full-stack authentication and profile management system for GUVI internship projects. Built with a focus on clean UI/UX, smooth animations, and strict GUVI compliance.

## 🎯 Project Overview

Portal Connect is a professional authentication platform featuring:
- **Modern UI**: Centered-card design with soft purple-blue gradient
- **Smooth Animations**: Page transitions with fade and slide effects
- **User Authentication**: Register, login, and profile management
- **GUVI Compliant**: jQuery AJAX + $_POST only, no PHP sessions
- **Responsive Design**: Mobile-friendly and accessible
- **Production Ready**: Deployed on AWS EC2 free tier

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, Bootstrap 5.3, jQuery 3.6 |
| **Backend** | PHP 8.x (Procedural) |
| **Database** | MySQL (users table), Redis (sessions), MongoDB (profiles) |
| **Hosting** | AWS EC2 (Ubuntu 22.04, t2.micro) |
| **Web Server** | Apache 2.4 |

## 📋 Features

### Authentication
- ✅ User registration with email and password
- ✅ Secure login with session tokens
- ✅ Password validation (min 6 chars, capital + number)
- ✅ Email validation

### Profile Management
- ✅ View user profile
- ✅ Update profile information
- ✅ Session-based access control
- ✅ Data persistence in MongoDB/MySQL

### UI/UX
- ✅ Animated card design
- ✅ Form field validation notes
- ✅ Real-time error/success messages
- ✅ Responsive across all devices
- ✅ Accessibility optimized

## 📂 Project Structure

```
guvi-login/
├── index.html              # Home page with registration form
├── register.html           # Registration page (Portal Connect)
├── login.html              # Login page (Portal Connect)
├── profile.html            # User profile page
├── css/
│   └── style.css          # Styles + animations
├── js/
│   ├── register.js        # Registration AJAX handler
│   ├── login.js           # Login AJAX handler
│   └── profile.js         # Profile AJAX handler
├── php/
│   ├── register.php       # Registration endpoint
│   ├── login.php          # Login endpoint
│   ├── profile.php        # Profile endpoint
│   └── RedisStub.php      # Redis stub for local development
├── vendor/
│   ├── autoload.php       # Autoloader
│   └── mongodb.php        # MongoDB stub
├── setup.sql              # Database schema
├── database.sql           # Sample data
└── README.md              # This file
```

## 🚀 How to Run Locally

### Prerequisites
- PHP 8.x with MySQLi extension
- MySQL Server 5.7+
- Git

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/srinidhigit28/guvi-login.git
   cd guvi-login
   ```

2. **Start PHP development server**
   ```bash
   php -S localhost:8000
   ```

3. **Create MySQL database**
   ```bash
   mysql -u root -p < setup.sql
   mysql -u root -p guvi_internship < database.sql
   ```

4. **Update database credentials** (if needed)
   - File: `php/register.php`, `php/login.php`
   - Default: `guvi_user` / `SecurePass#123`

5. **Open in browser**
   ```
   http://localhost:8000/
   ```

## 🎨 UI Design & Animations

### Centered Card Layout
- Clean, modern centered card with rounded corners
- Soft purple-blue gradient background (`#667eea` → `#764ba2`)
- White card with subtle shadow for depth

### Form Fields
- **Email**: Includes validation note about special characters
- **Password**: Includes validation note about capitals and numbers
- **Confirm Password**: Password verification field

### Animations
- **Page Load**: Smooth slide-up animation (0.6s, ease-out)
- **Form Inputs**: Cascade animation with staggered delays
- **Button Hover**: Elevation + shadow effect on interaction
- **Focus State**: Subtle border color change and glow effect

**Animation Timing**: 300-500ms with ease-in-out curves
**Implementation**: Pure CSS animations (no JS animation library required)

## 🔐 GUVI Compliance

✅ **Strict Compliance Rules:**
- AJAX-only requests (no page reloads on form submission)
- `$_POST` only (no `php://input` or `json_decode` on request bodies)
- MySQL prepared statements (prevents SQL injection)
- No PHP native sessions (`$_SESSION`)
- localStorage for session tokens (client-side)
- Redis backend for session data (server-side)
- JSON responses via `echo json_encode()`
- No CORS headers modification
- All form field IDs/names preserved

## 🌐 AWS EC2 Deployment

### EC2 Instance Setup

1. **Launch Instance**
   - AMI: Ubuntu Server 22.04 LTS
   - Instance Type: t2.micro (free tier)
   - Security Group: Allow ports 22 (SSH), 80 (HTTP)
   - Key Pair: Download and save securely

2. **SSH Into Server**
   ```bash
   ssh -i "path/to/key.pem" ubuntu@<public-ip>
   ```

3. **Install Apache, PHP, MySQL**
   ```bash
   sudo apt update
   sudo apt install -y apache2 php libapache2-mod-php php-mysql mysql-server
   sudo systemctl enable apache2
   sudo systemctl start apache2
   ```

4. **Clone Repository**
   ```bash
   cd /var/www/html
   sudo rm -rf *
   sudo git clone https://github.com/srinidhigit28/guvi-login.git .
   ```

5. **Fix Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/html
   sudo chmod -R 755 /var/www/html
   ```

6. **Setup MySQL Database**
   ```bash
   sudo mysql -e "CREATE DATABASE guvi_internship; \
   CREATE USER 'guvi_user'@'localhost' IDENTIFIED BY 'SecurePass#123'; \
   GRANT ALL PRIVILEGES ON guvi_internship.* TO 'guvi_user'@'localhost'; \
   FLUSH PRIVILEGES;"
   
   sudo mysql guvi_internship < /var/www/html/setup.sql
   sudo mysql guvi_internship < /var/www/html/database.sql
   ```

7. **Restart Apache**
   ```bash
   sudo systemctl restart apache2
   ```

8. **Verify Deployment**
   - Open: `http://<your-ec2-public-ip>/`
   - Test registration, login, and profile flows

## 📝 AJAX Endpoints

### Register Endpoint
- **URL**: `/php/register.php`
- **Method**: `POST`
- **Data**: `email` (string), `password` (string)
- **Response**: `{"status":"success"/"error", "message":"..."}`

### Login Endpoint
- **URL**: `/php/login.php`
- **Method**: `POST`
- **Data**: `email` (string), `password` (string)
- **Response**: `{"status":"success"/"error", "token":"...", "message":"..."}`

### Profile Endpoint
- **URL**: `/php/profile.php`
- **Method**: `POST`
- **Data**: `action` ("get"/"update"), `token` (string), profile fields
- **Response**: `{"status":"success"/"error", "data":{...}, "message":"..."}`

## 🔧 Configuration

### Database Credentials
File: `php/register.php`, `php/login.php`, `php/profile.php`
```php
$host = '127.0.0.1';
$username = 'guvi_user';
$password_db = 'SecurePass#123';
$database = 'guvi_internship';
```

### Session Storage
- **Redis**: TTL 3600 seconds (1 hour)
- **Fallback**: RedisStub using filesystem (`.redis_storage/`)

### Profile Storage
- **Primary**: MongoDB (stub via vendor/mongodb.php)
- **Fallback**: Filesystem JSON storage

## 📖 Usage Examples

### Register User
```javascript
$.ajax({
    url: 'php/register.php',
    type: 'POST',
    data: { email: 'user@mail.com', password: 'Pass123' },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success') {
            console.log('Registration successful');
        }
    }
});
```

### Login User
```javascript
$.ajax({
    url: 'php/login.php',
    type: 'POST',
    data: { email: 'user@mail.com', password: 'Pass123' },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success') {
            localStorage.setItem('sessionToken', response.token);
        }
    }
});
```

## 🐛 Troubleshooting

### Database Connection Error
- Verify MySQL is running: `sudo systemctl status mysql`
- Check credentials in PHP files match EC2 setup
- Ensure guvi_internship database exists: `SHOW DATABASES;`

### 500 Internal Server Error
- Check Apache error logs: `sudo tail /var/log/apache2/error.log`
- Verify PHP extensions installed: `php -m | grep mysqli`
- Check file permissions: `ls -la /var/www/html/`

### Assets Not Loading
- Verify files cloned correctly: `ls -la /var/www/html/css/`
- Check Apache default root: `DocumentRoot /var/www/html`
- Clear browser cache and refresh

## 📚 Additional Resources

- [Bootstrap 5.3 Docs](https://getbootstrap.com/docs/5.3/)
- [jQuery AJAX Docs](https://api.jquery.com/jQuery.ajax/)
- [PHP MySQLi Docs](https://www.php.net/manual/en/book.mysqli.php)
- [AWS EC2 Free Tier](https://aws.amazon.com/ec2/pricing/on-demand/)

## 📄 License

This project is part of the GUVI internship program. All rights reserved.

## 👨‍💻 Author

Created for GUVI Internship submission

## 🎓 GUVI Compliance Checklist

- ✅ AJAX-only communication
- ✅ $_POST method only
- ✅ MySQL prepared statements
- ✅ No PHP sessions
- ✅ localStorage + Redis backend
- ✅ No unauthorized CORS headers
- ✅ JSON responses
- ✅ Form validation
- ✅ Error handling
- ✅ Clean code structure
