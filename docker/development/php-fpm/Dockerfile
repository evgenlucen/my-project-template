FROM php:8.1-fpm-alpine3.16

ENV XDEBUG_VERSION 3.1.3

RUN apk add --no-cache postgresql-dev fcgi git bash \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install pdo_pgsql xdebug \
    && apk del git

# Установка необходимых пакетов для amqp
RUN apk add --no-cache unzip rabbitmq-c-dev autoconf g++ libc-dev make pkgconf re2c

# Установка и включение amqp
RUN pecl install amqp-1.11.0 \
    && docker-php-ext-enable amqp

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./common/php/php-fpm.d /usr/local/etc/php-fpm.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php-fpm/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s \
    CMD REDIRECT_STATUS=true SCRIPT_NAM E=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1

