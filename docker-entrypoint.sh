#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html

cd /var/www/html
echo -n "### Renomeando arquivo .env"
mv .env.example .env

echo -n "### Gerando chave da aplicação"
php artisan key:generate --ansi
echo -n "### Limpando caches da aplicação"
php artisan optimize:clear
echo -n "### Gerando cache das dependências da aplicação"
php artisan package:discover
echo -n "### Gerando cache de configuração da aplicação"
php artisan config:cache
echo -n "### Gerando cache das rotas da aplicação"
php artisan route:cache
echo -n "### Gerando cache das views da aplicação"
php artisan view:cache

exec "$@"
