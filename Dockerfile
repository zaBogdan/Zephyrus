FROM php:7.4-apache
RUN apt update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY src /var/www/html
RUN composer install
EXPOSE 80
