#!/bin/bash
set -e

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Running seeders (first deploy only, safe to re-run)..."
php artisan db:seed --force 2>/dev/null || echo "Seeder skipped (already seeded)"

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g "daemon off;"