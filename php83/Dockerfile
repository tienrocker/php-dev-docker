FROM php:8.3-apache

# Cài các gói hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev libssl-dev libmagickwand-dev \
    libicu-dev libpq-dev libjpeg62-turbo-dev libmemcached-dev \
    libcurl4-openssl-dev pkg-config libwebp-dev libxpm-dev libvpx-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mysqli \
        intl \
        xml \
        zip \
        opcache \
        bcmath \
        ftp \
        fileinfo \
        ctype \
    && pecl install redis mongodb imagick \
    && docker-php-ext-enable redis mongodb imagick \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Cài Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
