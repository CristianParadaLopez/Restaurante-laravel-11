# Usa PHP con Apache
FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    libpq-dev \
    default-mysql-client \
    default-libmysqlclient-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip sodium

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js para assets
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get update && apt-get install -y nodejs

# Configura Apache para servir desde public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf \
    && sed -i "s/80/8080/g" /etc/apache2/ports.conf \
    && a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia la aplicación
COPY . .

# Ajusta permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Instala dependencias de PHP y Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install

# Expone el puerto que Railway usa
EXPOSE 8080

# CMD para iniciar Laravel
CMD php artisan migrate --force && php artisan db:seed --force && apache2-foreground
