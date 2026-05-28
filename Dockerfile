FROM php:8.4-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    curl zip unzip git libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'app
COPY . .

# Installer les dépendances PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurer Apache
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/html>/,/<\/Directory>/s|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf

# Cache Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 80

CMD ["apache2-foreground"]
