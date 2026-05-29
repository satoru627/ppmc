FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    curl zip unzip git libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
