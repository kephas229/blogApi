#!/usr/bin/env bash
set -e

echo "==> Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Caching config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Creating storage symlink..."
php artisan storage:link || true

echo "==> Creating upload directories..."
mkdir -p public/uploads/blogs
mkdir -p public/uploads/temp

echo "==> Build complete."
