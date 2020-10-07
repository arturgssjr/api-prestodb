#!/bin/bash

if [ -z $1 ]; then
    echo -e "[ERROR] Favor informar a versão da API..."
    echo -e "[INFO]  Ex.: './gerar-build.sh v0.0.1'"
    exit
fi

API_VERSION=$1

echo -e "[INFO] Versão da API: ${API_VERSION}"

echo -e "[INFO] Gerando imagem do NGINX..."
docker build -f docker/nginx/Dockerfile -t arturgssjr/api-consulta-bigdata:nginx .

echo -e "[INFO] Gerando imagem da API..."
docker build -f docker/php/Dockerfile -t "arturgssjr/api-consulta-bigdata:${API_VERSION}" .

echo -e "[INFO] Gerando TAG da imagem..."
docker image tag "arturgssjr/api-consulta-bigdata:${API_VERSION}" arturgssjr/api-consulta-bigdata:latest

echo -e "[INFO] Enviando imagem para o Registry..."
docker push arturgssjr/api-consulta-bigdata:nginx
docker push arturgssjr/api-consulta-bigdata:latest
docker push "arturgssjr/api-consulta-bigdata:${API_VERSION}"