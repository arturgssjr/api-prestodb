FROM nginx:alpine

RUN rm -Rf /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf

ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf