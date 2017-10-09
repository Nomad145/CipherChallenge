FROM php:7.1-fpm

COPY conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-pecl-xdebug.ini
COPY conf/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update -y && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin \
      --filename=composer && \
      echo "phar.readonly = off" > /usr/local/etc/php/conf.d/phar.ini
