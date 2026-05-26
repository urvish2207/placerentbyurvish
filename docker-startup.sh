#!/bin/bash
set -e

echo "============================================"
echo " PlaceRent - Production Startup"
echo "============================================"

echo "==> Clearing and caching config..."
php artisan config:cache || echo "Config cache failed, continuing..."

echo "==> Caching routes..."
php artisan route:cache || echo "Route cache failed, continuing..."

echo "==> Caching views..."
php artisan view:cache || echo "View cache failed, continuing..."

echo "==> Running database migrations..."
php artisan migrate --force --no-interaction

echo "==> Creating storage link..."
php artisan storage:link || echo "Storage link already exists"

echo "==> Starting Apache web server..."
exec apache2-foreground
