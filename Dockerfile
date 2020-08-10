FROM php:7.4-apache
RUN apt update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
EXPOSE 80
