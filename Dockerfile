FROM mileschou/phalcon:7.0-apache

MAINTAINER Tega Oghenekohwo <tega.philip@gmail.com>

#COPY /docker/php/php.ini /usr/local/etc/php/

COPY /docker/php/000-default.conf /etc/apache2/sites-available/000-default.conf

#Enable mod_rewrite for apache
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y zlib1g-dev git && \
    docker-php-ext-install zip pdo_mysql && \
#Download composer
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    mkdir -p /var/www/html/padlock

#included for running mysql command line scripts during tests
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server

# Copy Source Code
COPY . /var/www/html/padlock/

WORKDIR /var/www/html/padlock

#install composer dependencies
RUN composer install
