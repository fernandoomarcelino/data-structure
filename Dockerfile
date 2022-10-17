FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y git unzip vim

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && mkdir -p docker/php/conf.d \
    && touch docker/php/conf.d/xdebug.ini \
    && touch docker/php/conf.d/error_reporting.ini

COPY ./.docker/xdebug/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
