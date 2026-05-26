FROM php:8.4-fpm-alpine

# Instalar dependências de sistema
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    nodejs \
    npm

# Instalar extensões PHP
RUN docker-php-ext-install gd zip pdo pdo_pgsql pdo_mysql opcache

# Instalar e habilitar Redis
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev $PHPIZE_DEPS

# Config PHP-FPM (pool + php settings unificado)
COPY ./docker/php/fpm-performance.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# OPcache e realpath cache (PHP_INI_SYSTEM - deve ir em .ini separado)
RUN echo "opcache.enable=1\nopcache.memory_consumption=256\nopcache.interned_strings_buffer=16\nopcache.max_accelerated_files=20000\nopcache.revalidate_freq=0\nopcache.validate_timestamps=1\nrealpath_cache_size=4096K\nrealpath_cache_ttl=600" > /usr/local/etc/php/conf.d/opcache.ini

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
