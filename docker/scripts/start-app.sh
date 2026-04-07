#!/bin/bash
set -e

echo "=> Iniciando Bootstrap Otimizado do Laravel..."

# O container só levanta depois do vendor ser instanciado ou montado
if [ ! -d "vendor" ]; then
    echo "Rodando composer install..."
    composer install --no-interaction --optimize-autoloader
fi

# Se houver package.json mas a build nao existir, buildamos
if [ ! -d "public/build" ] && [ -f "package.json" ]; then
    echo "Falta pasta de assets (Vite), compilando para não dar erro..."
    npm install && npm run build
fi

# Aguardando PostgreSQL opcional
# echo "Checando conexões do banco..." 

# Operações de Banco
echo "Migrando BD SQLite..."
touch database/database.sqlite
php artisan migrate --force

echo "Garantindo otimização (Caching)..."
# Sempre em ambiente prod/docker ideal: 
php artisan optimize:clear

if [ "$APP_ENV" != "local" ]; then
    # Para produção / subida final pesada:
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    echo "=> CACHES AQUECIDOS!"
else
    # Se local e app_debug=true no docker desktop, não passe cache 
    # de config/rotas agressivo que quebra o hot reload de backend de devs juniors.
    echo "=> APP_ENV=local - Rodando sem config:cache rígido para permitir edição fluída"
fi

# Ajustando permissoes criticas (se subir como root dnv)
chown -R www-data:www-data storage bootstrap/cache

echo "=> Iniciando PHP-FPM Master Process!"
exec php-fpm
