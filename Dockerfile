FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    mariadb-connector-c-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy existing application directory permissions
COPY . /var/www
RUN chown -R www-data:www-data /var/www
