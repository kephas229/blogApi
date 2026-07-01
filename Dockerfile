FROM php:8.3-apache

# Extensions PHP nécessaires pour Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . .

# Dépendances PHP (sans les packages dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Dossiers uploads et permissions
RUN mkdir -p public/uploads/blogs public/uploads/temp \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache public/uploads

# Pointer Apache sur le dossier public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Script de démarrage
COPY docker-start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

EXPOSE 80

CMD ["/usr/local/bin/start"]
