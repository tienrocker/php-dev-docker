# docker build -t tienrocker/php-apache-phalcon3:1.0.2 .
# docker image push tienrocker/php-apache-phalcon3:1.0.2
FROM php:7.3.33-apache

LABEL version="1.0.2" maintainer="Tien Tran <tienrocker@gmail.com>"

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y curl pkg-config libssl-dev openssl libcurl4-openssl-dev \
    gnupg lsb-release libpcre3 libpcre3-dev autoconf zlib1g-dev libzip-dev zip unzip \
    libpq-dev imagemagick libfreetype6-dev libjpeg62-turbo-dev libmagickwand-dev \
    libpng-dev libwebp-dev libxpm-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Install PHP extensions
RUN pecl channel-update pecl.php.net && \
    pecl install mongodb-1.7.3 imagick redis-5.3.1 && \
    docker-php-ext-enable mongodb imagick redis
RUN docker-php-ext-configure gd \
    --with-gd \
    --with-webp-dir \
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib-dir \
    --with-xpm-dir \
    --with-freetype-dir && \
    docker-php-ext-install -j$(nproc) gd bcmath mbstring mysqli pdo pdo_mysql \
    exif zip intl gettext curl json opcache iconv fileinfo calendar

# Install Phalcon
RUN docker-php-source extract
RUN mkdir -p /usr/src/php/ext/phalcon && \
    curl -fsSL https://github.com/phalcon/cphalcon/archive/refs/tags/v3.4.5.tar.gz | tar xvz -C /usr/src/php/ext/phalcon --strip 1 && \
    cd /usr/src/php/ext/phalcon/build && ./install && \
    echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/docker-php-ext-phalcon.ini && \
    docker-php-ext-enable phalcon

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer