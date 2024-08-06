FROM php:8.2-fpm
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        cron \
    && docker-php-ext-install \
        zip \
        intl \
		mysqli \
        pdo pdo_mysql soap
    
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
COPY courier/ /var/www/symfony
WORKDIR /var/www/symfony/

COPY crontab /etc/cron.d/check-cron
RUN crontab /etc/cron.d/check-cron
RUN touch /var/log/cron.log