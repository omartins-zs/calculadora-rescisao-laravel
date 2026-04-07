FROM php:8.3-fpm-alpine

# Instalar dependências de sistema mínimas e de build
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    nodejs \
    npm

# Instalar extensões PHP (Postgres, MySQL, GD, Zip, OPcache)
RUN docker-php-ext-install gd zip pdo pdo_pgsql pdo_mysql opcache

# Instalar e habilitar Redis
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev $PHPIZE_DEPS

# Copias de OPcache e PHP configs otimizados pro FPM
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY ./docker/php/fpm-performance.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Obter Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar script de boot
COPY ./docker/scripts/start-app.sh /usr/local/bin/start-app.sh
RUN chmod +x /usr/local/bin/start-app.sh

# Não fazemos COPY manual do projeto nesta imagem base em caso de Bind de volume 
# Mas para garantir build prod pronta, deixaremos:
COPY . .

RUN composer install --no-interaction --optimize-autoloader
RUN npm install && npm run build
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 9000

CMD ["/usr/local/bin/start-app.sh"]
