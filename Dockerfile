FROM php:7.2-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN echo "date.timezone=UTC" >> $PHP_INI_DIR/php.ini
RUN apk --no-cache add git unzip
COPY --from=composer:1.7 /usr/bin/composer /usr/bin/composer
