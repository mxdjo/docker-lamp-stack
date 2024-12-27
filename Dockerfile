ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-apache

RUN apt-get update && apt-get upgrade -y

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

EXPOSE 80
