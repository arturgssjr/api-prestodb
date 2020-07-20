#!/bin/bash

cp -R /var/www/tmp/. /var/www/html/
chown -R www-data:www-data /var/www/html

cd /var/www/html
mv .env.example .env

exec "$@"
