ARG PHP_VERSION

FROM shinsenter/symfony:php${PHP_VERSION} AS base

FROM base AS dev

# Install xdebug
RUN phpaddmod xdebug
