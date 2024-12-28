FROM php:8.3.13-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    git \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql intl zip


COPY ./ /var/www/html/

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN composer i
