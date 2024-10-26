ARG PHP_VERSION
ARG COMPOSER_VERSION

FROM composer:${COMPOSER_VERSION} AS composer

FROM php:${PHP_VERSION}-fpm AS base

# Update package list
RUN apt-get update

# Install composer dependencies
RUN apt-get install -y \
    git \
    unzip

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

FROM base AS development

# Install PHP extensions
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install dependencies
COPY composer.json composer.lock ./

RUN composer install
