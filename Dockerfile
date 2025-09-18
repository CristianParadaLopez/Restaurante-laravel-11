# Imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias de Laravel y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar carpeta de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Dar permisos de escritura a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Configurar Apache para servir Laravel desde /var/www/html/public
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Limpiar cachés de Laravel (por seguridad en producción)
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Exponer puerto 80
EXPOSE 80

# Comando de inicio (Apache con Laravel en public/)
CMD ["apache2-foreground"]
