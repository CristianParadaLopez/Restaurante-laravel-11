FROM php:8.2-apache

# Evitar que apt pregunte durante la instalación
ENV DEBIAN_FRONTEND=noninteractive

# Tomar el puerto dinámico de Railway
ENV PORT 8080

# Instalar dependencias del sistema y extensiones de PHP necesarias
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

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Dar permisos de escritura a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Configurar Apache para servir Laravel desde /public y usar el puerto dinámico
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Ejecutar migraciones y cache de Laravel en build
RUN php artisan migrate --force \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Exponer el puerto que Railway proporciona
EXPOSE ${PORT}

# Ejecutar Apache en primer plano
CMD ["apache2-foreground"]
