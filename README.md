# GUVI Internship: Register → Login → Profile

A fully GUVI-compliant PHP full-stack app with jQuery AJAX frontend and PHP backend using MySQL for auth, MongoDB (stub) for profiles, and Redis (stub) for session storage. Designed to run locally on XAMPP and deployable on AWS EC2 (LAMP).

## Features
- Register and Login with hashed passwords (bcrypt)
- Profile view and update (age, dob, contact)
- jQuery AJAX-only communication (no form submits, no fetch)
- PHP uses only `$_POST` / `$_GET` and returns JSON via `echo json_encode(...)`
- MySQL prepared statements everywhere
- Client session stored in `localStorage`; backend session stored via Redis stub

## Tech Stack
- Frontend: HTML5, Bootstrap 5, jQuery 3.6
- Backend: PHP 8+ (procedural)
- Databases: MySQL (auth), MongoDB stub (profiles), Redis stub (sessions)
- Server: Apache (XAMPP locally, Apache on EC2)

## Local Setup (XAMPP)
1. Install XAMPP and start Apache + MySQL
2. Copy project to `C:\xampp\htdocs\guvi`
3. Create DB and table:
   ```sql
   CREATE DATABASE IF NOT EXISTS guvi_internship;
   USE guvi_internship;
   CREATE TABLE IF NOT EXISTS users (
     id INT PRIMARY KEY AUTO_INCREMENT,
     email VARCHAR(255) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```
4. Visit `http://localhost/guvi/register.html`

## AWS EC2 (Free Tier) – LAMP Deploy
1. Launch Ubuntu EC2 (t2.micro), allow inbound: 22, 80
2. SSH in and install LAMP:
   ```bash
   sudo apt update
   sudo apt install -y apache2 php php-mysql git
   sudo systemctl enable --now apache2
   ```
3. Deploy code:
   ```bash
   sudo rm -rf /var/www/html/*
   sudo git clone https://github.com/<your-username>/<your-repo>.git /var/www/html
   sudo chown -R www-data:www-data /var/www/html
   sudo chmod -R 755 /var/www/html
   ```
4. MySQL (RDS or local):
   ```bash
   sudo apt install -y mysql-server
   sudo mysql -e "CREATE DATABASE IF NOT EXISTS guvi_internship;"
   sudo mysql guvi_internship < /var/www/html/database.sql  # if present
   ```
5. Open `http://<EC2-PUBLIC-IP>/register.html`

## GUVI Compliance Notes
- jQuery AJAX only; no `fetch`, no `axios`
- Backend uses only `$_POST` / `$_GET`; no `php://input`
- JSON responses via `echo json_encode([...])`
- No PHP sessions; client uses `localStorage`
- Redis/MongoDB stubs ensure app runs without extra services

## Repository Hygiene
- See `.gitignore` for ignored folders/files
- Commit only source files (HTML/CSS/JS/PHP/SQL)

## Troubleshooting
- If MySQL errors: ensure `127.0.0.1` and DB exists
- If profile fails: MongoDB stub is used via `vendor/autoload.php`
- Clear local session: open DevTools Console and run `localStorage.clear()`
