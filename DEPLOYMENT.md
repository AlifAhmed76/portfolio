# Production Deployment & Operations Guide

This guide details the procedure for deploying the **Md. Alif Ahmed Portfolio & Enterprise CMS** to a production VPS (Ubuntu 22.04 / 24.04 LTS), configuring Nginx, PHP 8.2-FPM, MySQL/MariaDB, SSL certificates, queue workers, and automated backups.

---

## 1. Server Prerequisites
- **Operating System**: Ubuntu 22.04 LTS or 24.04 LTS (x86_64)
- **Web Server**: Nginx (1.20+)
- **PHP**: PHP 8.2+ with extensions: `php8.2-fpm`, `php8.2-mysql`, `php8.2-mbstring`, `php8.2-xml`, `php8.2-curl`, `php8.2-gd`, `php8.2-zip`, `php8.2-intl`, `php8.2-bcmath`, `php8.2-sodium`
- **Database**: MariaDB 10.4+ or MySQL 8.0+
- **Process Manager**: Supervisor
- **Package Managers**: Composer 2.7+, Node.js 18+ & npm

```bash
# Install core packages on Ubuntu
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mariadb-server php8.2-fpm php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-gd php8.2-zip php8.2-intl php8.2-bcmath php8.2-sodium \
    git curl unzip supervisor certbot python3-certbot-nginx
```

---

## 2. Database Initialization
```bash
sudo mysql -u root
```
```sql
CREATE DATABASE alif_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'alif_user'@'localhost' IDENTIFIED BY 'StrongProductionPasswordHere!';
GRANT ALL PRIVILEGES ON alif_portfolio.* TO 'alif_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 3. Application Deployment

```bash
# Clone repository into web root
cd /var/www
git clone https://github.com/alifahmed/portfolio.git alif_portfolio
cd /var/www/alif_portfolio

# Set environment
cp .env.example .env
nano .env # Configure production DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL, etc.

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Generate app key & run migrations with seed
php artisan key:generate --force
php artisan migrate --force --seed
php artisan storage:link

# Permissions
sudo chown -R www-data:www-data /var/www/alif_portfolio
sudo chmod -R 775 /var/www/alif_portfolio/storage /var/www/alif_portfolio/bootstrap/cache
```

---

## 4. Nginx Server Configuration

Create `/etc/nginx/sites-available/alifahmed.com`:
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name alifahmed.com www.alifahmed.com;
    root /var/www/alif_portfolio/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site and install SSL:
```bash
sudo ln -s /etc/nginx/sites-available/alifahmed.com /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Issue Let's Encrypt SSL
sudo certbot --nginx -d alifahmed.com -d www.alifahmed.com
```

---

## 5. Supervisor Worker Configuration

Create `/etc/supervisor/conf.d/alif-worker.conf`:
```ini
[program:alif-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/alif_portfolio/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/alif_portfolio/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start alif-worker:*
```

---

## 6. Cron Task Scheduling & Automated Backups

Edit crontab for `www-data`:
```bash
sudo crontab -u www-data -e
```
Add:
```cron
# Laravel Task Scheduler
* * * * * cd /var/www/alif_portfolio && php artisan schedule:run >> /dev/null 2>&1

# Daily Automated Database & Media Backup (03:00 AM)
0 3 * * * cd /var/www/alif_portfolio && php artisan portfolio:backup >> /var/www/alif_portfolio/storage/logs/backup.log 2>&1
```

---

## 7. Production Cache Optimization
Run during each production deployment:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
To clear caches after theme updates or configuration edits:
```bash
php artisan optimize:clear
```
