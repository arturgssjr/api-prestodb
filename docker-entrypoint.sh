#!/bin/bash

echo -e "### Criando pasta 'storage'"
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/testing
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs

echo -e "### Atribuindo permissões ao projeto"
chown -R www-data:www-data /var/www/html

cd /var/www/html

echo -e "### Renomeando arquivo .env"
mv .env.example .env

echo -e "### Gerando chave da aplicação"
php artisan key:generate --ansi
echo -e "### Limpando caches da aplicação"
php artisan optimize:clear
echo -e "### Gerando cache das dependências da aplicação"
php artisan package:discover
echo -e "### Gerando cache de configuração da aplicação"
php artisan config:cache
echo -e "### Gerando cache das rotas da aplicação"
php artisan route:cache
echo -e "### Gerando cache das views da aplicação"
php artisan view:cache

exec "$@"
