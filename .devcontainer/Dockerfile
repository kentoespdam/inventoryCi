FROM php:8.0-cli

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        curl \
        procps \
        sudo \
        nano \
        vim-tiny \
        ca-certificates \
        libicu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        intl \
        mbstring \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        exif \
        xml \
        curl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN { \
        echo 'memory_limit = 512M'; \
        echo 'upload_max_filesize = 64M'; \
        echo 'post_max_size = 64M'; \
        echo 'max_execution_time = 300'; \
        echo 'date.timezone = Asia/Jakarta'; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

RUN { \
        echo 'xdebug.mode = debug,develop'; \
        echo 'xdebug.start_with_request = trigger'; \
        echo 'xdebug.client_host = host.docker.internal'; \
        echo 'xdebug.client_port = 9003'; \
        echo 'xdebug.discover_client_host = true'; \
    } > /usr/local/etc/php/conf.d/zz-xdebug.ini

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data || true

RUN mkdir -p /var/www/html /var/www/.vscode-server /var/www/.vscode-server-insiders /var/www/.composer \
    && chown -R www-data:www-data /var/www \
    && usermod -s /bin/bash www-data \
    && echo 'www-data ALL=(ALL) NOPASSWD:ALL' > /etc/sudoers.d/www-data \
    && chmod 0440 /etc/sudoers.d/www-data

WORKDIR /var/www/html
