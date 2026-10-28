FROM php:8.4-fpm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# unzip нужен composer'у для распаковки пакетов
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
