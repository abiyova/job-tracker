FROM php:8.3-apache


# 1. Aktifkan modul rewrite Apache (wajib untuk routing Laravel)

RUN a2enmod rewrite


# 2. Install dependensi sistem yang dibutuhkan Laravel

RUN apt-get update && apt-get install -y \

    git \

    unzip \

    zip \

    libzip-dev \

    libpng-dev \

    libicu-dev \

    libxml2-dev \

    libonig-dev


# 3. Install ekstensi PHP

RUN docker-php-ext-install \

    pdo_mysql \

    mbstring \

    zip \

    intl \

    gd \

    bcmath


# 4. Install Composer

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# 5. Tentukan lokasi kerja di dalam kontainer

WORKDIR /var/www


# 6. Ubah DocumentRoot Apache agar mengarah ke folder /public Laravel

ENV APACHE_DOCUMENT_ROOT /var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
