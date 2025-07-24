FROM php:8.2-apache

# Installer dépendances pour GD (WebP) et PDO MySQL
RUN apt-get update && apt-get install -y libwebp-dev libjpeg-dev libpng-dev unzip \
    && docker-php-ext-configure gd --with-webp --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Installer Composer globalement
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier les fichiers de l'application
COPY . /var/www/html/

# Installer les dépendances PHP via Composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN a2enmod rewrite

EXPOSE 80
