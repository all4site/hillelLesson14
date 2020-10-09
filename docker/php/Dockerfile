FROM php:7.4-fpm

RUN apt-get update && apt-get install -yqq \
    zip \
    && docker-php-ext-install pdo_mysql

WORKDIR /app