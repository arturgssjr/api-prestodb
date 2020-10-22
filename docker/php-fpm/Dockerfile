FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    vim \
    g++ \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libmemcached-dev \
    libfreetype6-dev \
    libmagickwand-dev --no-install-recommends

RUN pecl install -o -f redis imagick \
    && rm -rf /tmp/pear

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    pcntl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql

RUN docker-php-ext-enable \
    redis \    
    imagick

COPY ./docker/php-fpm/php7.4.ini $PHP_INI_DIR/php.ini
COPY ./docker/php-fpm/laravel.ini $PHP_INI_DIR/conf.d
COPY ./docker/php-fpm/xlaravel.pool.conf /usr/local/etc/php-fpm.d/

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs

RUN mkdir /app

COPY . /app

RUN chmod +x /app/docker/php-fpm/entrypoint.sh

RUN cd /app && \
    rm -rfv html vendor composer.lock node_modules package-lock.json && \
    composer install --optimize-autoloader --no-dev && \
    npm install && \
    npm run dev

RUN groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 -g www-data www-data

RUN chown -R www-data:www-data /app

USER www-data

WORKDIR /code
