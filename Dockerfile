# Image officielle PHP avec Apache
FROM php:8.2-apache

# Mise à jour et installation des dépendances nécessaires
RUN apt-get update && apt-get install -y \
    unzip zip git curl libwebp-dev libjpeg-dev libpng-dev \
    && docker-php-ext-configure gd --with-webp --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Installer Composer globalement
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier les fichiers Composer avant d'installer les dépendances
COPY composer.json composer.lock /var/www/html/

# Définir le dossier de travail
WORKDIR /var/www/html

# Installer les dépendances PHP (sans les dev)
RUN composer install --no-dev --optimize-autoloader

# Copier tout le reste de l’application, y compris le dossier Asset
COPY . /var/www/html/

# Droits d'accès corrects
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Activer mod_rewrite
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80
