#!/bin/bash


set -e

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Generating Laravel cache files..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Installing Node dependencies..."
npm ci --production=false

echo "Building frontend assets..."
npm run build

echo "Verifying cache files were created..."
if [ -f "bootstrap/cache/config.php" ]; then
    echo "✓ Config cache created"
else
    echo "✗ Config cache missing"
    exit 1
fi

if [ -f "bootstrap/cache/routes-v7.php" ]; then
    echo "✓ Routes cache created"
else
    echo "✗ Routes cache missing"
    exit 1
fi

if [ -d "storage/framework/views" ]; then
    echo "✓ Views directory exists"
else
    echo "✗ Views directory missing"
    exit 1
fi

echo "Build completed successfully!"
