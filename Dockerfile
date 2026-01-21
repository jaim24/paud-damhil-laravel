# Laravel Production Dockerfile for Railway
# Simplified version using php artisan serve
FROM php:8.3-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    icu-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Copy package.json for npm
COPY package.json package-lock.json ./

# Install Node dependencies
RUN npm ci

# Copy rest of application
COPY . .

# Run composer scripts
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Set permissions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Create required directories
RUN mkdir -p /var/www/html/storage/logs \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views

# Expose port (Railway will set PORT env var)
EXPOSE 8080

# Start script that runs migrations then starts server
CMD sh -c "php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php artisan storage:link || true && \
    php artisan serve --host=0.0.0.0 --port=\${PORT:-8080}"
