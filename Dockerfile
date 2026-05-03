FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (PostgreSQL үшін pdo_pgsql қосылды)
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Composer dependencies алдымен (cache үшін)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Барлық файлдарды көшіру
COPY . .

# Laravel setup
RUN composer dump-autoload --optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 8080

# Start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]