FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    netcat-openbsd zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get update \
    && apt-get install -y symfony-cli \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

RUN sed -i 's/Listen 80/Listen 8000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8000>/' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/public#' /etc/apache2/sites-available/000-default.conf

RUN echo '<Directory /var/www/public>\n\
    AllowOverride None\n\
    Require all granted\n\
    FallbackResource /index.php\n\
</Directory>' > /etc/apache2/conf-available/symfony.conf \
    && a2enconf symfony \
    && a2enmod rewrite