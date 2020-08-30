FROM php:7.4-fpm-alpine

COPY . /var/www/forum

WORKDIR /var/www/forum

RUN  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer install --no-interaction --optimize-autoloader #--no-dev

RUN chown -R www-data:www-data /var/www/forum \
    && chmod -R 750 /var/www/forum

RUN apk update && apk add --no-cache oniguruma-dev \
    unzip \
    libxml2-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    sockets \
    json \
    soap \
    mbstring \
    opcache \
    && docker-php-source delete

RUN rm -rf /var/cache/apk/*

EXPOSE 9000
