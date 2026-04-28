FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

# IMPORTANT: serve from public folder

CMD sh -c "mkdir -p database && touch database/database.sqlite && php -S 0.0.0.0:10000 -t public"