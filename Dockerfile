FROM php:7.4-apache
RUN apt update && apt-get upgrade -y
RUN apt install -y zip
RUN docker-php-ext-install mysqli 
RUN a2enmod rewrite
EXPOSE 80
