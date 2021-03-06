FROM php:7.3-fpm

MAINTAINER OndraVotava <ja@ondravotav.cz>

RUN apt-get update && apt-get install -y \
	 g++ \
	 git \
	 curl \
	 libfreetype6-dev \
	 libcurl3-dev \
	 libicu-dev \
	 libfreetype6-dev \
	 libjpeg-dev \
	 libjpeg62-turbo-dev \
	 libmagickwand-dev \
	 libpq-dev \
	 libpng-dev \
	 libxml2-dev \
	 libxslt-dev \
	 zlib1g-dev \
	 openssh-client \
	 nano \
	 unzip \
	 redis-server \
	 libzip-dev \
	 gnupg2 \
    apt-transport-https \
    && docker-php-ext-install opcache \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install xml \
    && docker-php-ext-install xsl \
    && docker-php-ext-configure gd --with-jpeg-dir=/usr/lib \
    && docker-php-ext-install gd \
    && pecl install apcu-5.1.11 \
    && docker-php-ext-enable apcu

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update && apt-get install -y yarn

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

COPY ./php.d/xx-custom-php.ini  /usr/local/etc/php/conf.d/xx-custom-php.ini

RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Prague /etc/localtime \
    && "date"

WORKDIR /var/www/symfony

EXPOSE 9000
