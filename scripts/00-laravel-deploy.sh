#!/usr/bin/env bash
set -e

echo "==> Optimizing Laravel for Production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true

echo "==> Deployment hooks completed."
