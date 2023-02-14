FROM php:8.2.2-apache

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        git \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install gd \
    && a2enmod rewrite \
    && a2enmod headers


RUN mkdir /src \
    && mkdir /src/public

RUN sed -ri -e 's!/var/www/html!/src/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/src/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart