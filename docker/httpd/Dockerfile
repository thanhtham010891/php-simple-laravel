FROM php:7.2-apache

ENV APACHE_LOG_DIR /var/www/html/log
COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN apt-get -y update && apt-get -y install zip unzip
RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN a2enmod ssl rewrite

EXPOSE 80
WORKDIR /var/www/html
COPY ./build.sh /build.sh

ENTRYPOINT ["/build.sh"]
