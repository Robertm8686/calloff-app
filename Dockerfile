FROM php:8.2-cli

# Install system dependencies + PostgreSQL support
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Serve Laravel from public folder
CMD sh -c "php artisan migrate --force && php -S 0.0.0.0:10000 -t public"