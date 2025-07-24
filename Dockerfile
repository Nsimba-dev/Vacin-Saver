# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Copie tous les fichiers du projet dans le dossier web d'Apache
COPY . /var/www/html/

# Donne les bons droits d'accès
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Active le module Apache mod_rewrite (utile pour les frameworks ou .htaccess)
RUN a2enmod rewrite

# Expose le port 80
EXPOSE 80
