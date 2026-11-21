#!/usr/bin/env bash

# Ensure composer dependencies exist
if [ ! -f "/var/www/html/vendor/autoload.php" ]; then
    echo "==> Installing Composer dependencies..."
    composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
fi

echo "==> Optimizing Laravel for Production..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

echo "==> Deployment hooks completed successfully."
