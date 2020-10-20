#!/bin/bash

if [ -z $1 ]; then
    echo -e "[ERROR] Falha ao gerar imagem!"
    echo -e "[INFO]  Ex.: ./gerar-imagem.sh php|nginx"
    exit
fi

if [ $1 == 'php' ]; then
    API_VERSION=`php artisan app:version`
    if [ -z $API_VERSION ]; then
        echo -e "[ERROR] Falha ao recuperar versão da aplicação!"
        exit
    fi

    echo -e "[INFO] Gerando imagem da API..."
    echo -e "[INFO] Versão da API: ${API_VERSION}"
    docker build -f docker/php-fpm/Dockerfile -t "arturgssjr/api-consulta-bigdata:${API_VERSION}" .
    echo -e "[INFO] Gerando TAG da imagem..."
    docker image tag "arturgssjr/api-consulta-bigdata:${API_VERSION}" arturgssjr/api-consulta-bigdata:latest
    echo -e "[INFO] Enviando imagem para o Registry..."
    docker push arturgssjr/api-consulta-bigdata:latest
    docker push "arturgssjr/api-consulta-bigdata:${API_VERSION}"
fi

if [ $1 == 'nginx' ]; then
    echo -e "[INFO] Gerando imagem do NGINX..."
    docker build -f docker/nginx/Dockerfile -t arturgssjr/api-consulta-bigdata:nginx .
    echo -e "[INFO] Gerando TAG da imagem..."
    docker image tag arturgssjr/api-consulta-bigdata:nginx arturgssjr/api-consulta-bigdata:nginx
    echo -e "[INFO] Enviando imagem para o Registry..."
    docker push arturgssjr/api-consulta-bigdata:nginx
fi