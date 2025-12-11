#!/bin/bash
set -e

echo "🚀 Starting deployment..."

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Generate key if not exists
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating app key..."
    php artisan key:generate --force
fi

# Clear and cache config
echo "⚙️  Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link || true

# Seed categories if needed
echo "🌱 Seeding initial data..."
php artisan db:seed --class=CategorySeeder --force || true

echo "✅ Deployment completed successfully!"
