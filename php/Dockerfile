# Upewniamy się, że używamy wersji PHP z FPM
FROM php:8.2-fpm

# Ustawiamy katalog roboczy
WORKDIR /var/www

# Instalujemy wymagane pakiety i rozszerzenia PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalujemy Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Upewniamy się, że PHP-FPM działa
CMD ["php-fpm"]

RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

