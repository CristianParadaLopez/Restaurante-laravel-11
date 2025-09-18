FROM php:8.2-apache

ENV DEBIAN_FRONTEND=noninteractive
ENV PORT 8080

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        intl \
        bcmath \
        mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache

RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Cache de Laravel (sin migraciones)
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

EXPOSE ${PORT}
CMD ["apache2-foreground"]
