FROM php:8.1-fpm-alpine3.16

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
        bcmath \
        gd \
        intl \
        opcache \
        pcntl \
        pdo \
        pdo_mysql \
        sockets \
        zip

RUN apk update && \
		apk add --no-cache $PHPIZE_DEP\
		git \
        libzip-dev \
        libpng-dev \
        postgresql-dev \
        unzip \
        zip \
        yarn

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install
