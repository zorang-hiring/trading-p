ARG PHP_FPM_VERSION
FROM php:${PHP_FPM_VERSION}-fpm

RUN docker-php-ext-install pdo_mysql

# for tests:
RUN pecl install xdebug && docker-php-ext-enable xdebug

# required with manipilating with some php composer packages
RUN apt-get -y update
RUN apt-get -y install git

ADD start.sh /
RUN chmod +x /start.sh
ENTRYPOINT ["/start.sh"]

EXPOSE 9000
