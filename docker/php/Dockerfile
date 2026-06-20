FROM php:8.2-fpm

ARG APP_ENV
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=$APP_ENV

RUN apt-get update && apt-get install -y \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
        cron \
        tzdata \
        wget \
    && docker-php-ext-install \
        zip \
        intl \
		mysqli \
        pdo pdo_mysql soap

ENV TZ="America/Bogota"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
COPY courier/ /var/www/symfony
WORKDIR /var/www/symfony/

COPY crontab /etc/cron.d/check-cron
RUN chown root:root /etc/cron.d/check-cron && chmod 0644 /etc/cron.d/check-cron
RUN touch /var/log/cron.log && chown www-data:www-data /var/log/cron.log
RUN chown www-data:www-data /var/www
RUN echo "APP_ENV=$APP_ENV" >> /etc/environment