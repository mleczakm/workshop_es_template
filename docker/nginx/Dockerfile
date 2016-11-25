FROM ubuntu:16.10

RUN apt-get update && apt-get install -y nginx \
    php-fpm \
    php-cli \
    curl \
    php-curl \
    php7.0-bcmath \
    php7.0-mbstring \
    zip \
    unzip \
    git \
    php7.0-xml \
    php7.0-mysql \
    php-curl

COPY site.conf /etc/nginx/conf.d/site.conf
COPY run.sh /run.sh

WORKDIR /code
EXPOSE 80 443

ENTRYPOINT ["/bin/bash", "/run.sh"]