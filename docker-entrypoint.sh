#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html

cd /var/www/html
mv .env.example .env

php artisan key:generate --ansi
php artisan optimize:clear
php artisan package:discover
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
