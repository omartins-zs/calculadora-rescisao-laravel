FROM php:8.3-cli-alpine

# Instalar dependências de sistema
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    nodejs \
    npm

# Instalar extensões PHP (Postgres, MySQL, GD, Zip)
RUN docker-php-ext-install gd zip pdo pdo_pgsql pdo_mysql

# Instalar e habilitar Redis
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev $PHPIZE_DEPS

# Obter Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /app

# Copiar projeto
COPY . .

# Instalar dependências PHP e Node, e buildar assets
RUN composer install --no-interaction --optimize-autoloader
RUN npm install && npm run build

# Ajustar permissões para os diretórios sensíveis do Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expor porta
EXPOSE 8000

# Comando padrão
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
