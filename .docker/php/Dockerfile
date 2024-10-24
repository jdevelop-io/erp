FROM php:8.3-alpine AS base

# Update and install dependencies
RUN apk update && apk add --no-cache --update \
    $PHPIZE_DEPS \
    linux-headers \
    git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

FROM base AS dev

# Install xdebug
RUN apk add --no-cache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy xdebug configuration
COPY .docker/php/xdebug.ini /etc/php83/conf.d/50_xdebug.ini

# Copy the composer.json and composer.lock files
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate the autoloader
RUN composer dump-autoload --optimize
