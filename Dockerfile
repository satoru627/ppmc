FROM dunglas/frankenphp:php8.4-bookworm

RUN apt-get update && apt-get install -y \
    curl zip unzip git npm nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts --no-interaction

COPY package.json package-lock.json ./
RUN npm install && npm run build

COPY . .

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
