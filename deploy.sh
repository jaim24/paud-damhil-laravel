#!/bin/bash
# ============================================
# Laravel Production Deployment Script
# PAUD Damhil - Sistem Absensi Guru
# ============================================

set -e  # Exit on error

echo "🚀 Starting deployment..."

# 1. Pull latest code
echo "📥 Pulling latest code from repository..."
git pull origin main

# 2. Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# 3. Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 4. Cache configuration for performance
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Link storage
echo "🔗 Linking storage..."
php artisan storage:link || true

# 6. Install and build frontend assets
echo "🎨 Building frontend assets..."
npm install
npm run build

# 7. Clear old caches
echo "🧹 Clearing old caches..."
php artisan cache:clear

# 8. Set permissions (Linux/Mac only)
if [[ "$OSTYPE" == "linux-gnu"* ]] || [[ "$OSTYPE" == "darwin"* ]]; then
    echo "🔐 Setting file permissions..."
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
fi

echo "✅ Deployment completed successfully!"
echo ""
echo "📋 Post-deployment checklist:"
echo "   1. Verify .env configuration (especially APP_URL, DB settings)"
echo "   2. Test API endpoints with Postman or curl"
echo "   3. Check storage/logs for any errors"
echo ""
