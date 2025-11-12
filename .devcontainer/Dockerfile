# Gunakan image PHP 8.0.12-FPM berbasis Debian Bullseye
FROM php:8.0.12-fpm-bullseye

# Set non-interactive untuk instalasi paket
ENV DEBIAN_FRONTEND=noninteractive

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libicu-dev \
    libonig-dev \
    git \
    curl \
    unzip \
    wget \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 16.x (versi yang direkomendasikan untuk CI4) dari repository resmi NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install ekstensi PHP yang diperlukan
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    mysqli \
    zip \
    intl \
    bcmath \
    opcache

# Install dan konfigurasi Xdebug 3 (kompatibel dengan PHP 8.0)
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Konfigurasi Xdebug untuk terhubung ke host
RUN echo "xdebug.mode = debug,develop" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log = /tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Salin file composer terlebih dahulu untuk memanfaatkan cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Salin seluruh kode aplikasi
COPY . .

# Set kepemilikan file ke www-data (user yang digunakan oleh Nginx dan PHP-FPM)
RUN chown -R www-data:www-data /var/www/html