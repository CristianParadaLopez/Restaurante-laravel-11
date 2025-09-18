# Imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias de Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar carpeta de trabajo
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Dar permisos de escritura a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando de inicio (Apache con Laravel en public/)
CMD ["apache2-foreground"]
