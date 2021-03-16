FROM alpine:latest

WORKDIR /var/www/html/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl sqlite nginx supervisor

# Installing bash
RUN apk add bash && sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing PHP
RUN apk add --no-cache php8 \
    php8-common \
    php8-fpm \
    php8-pdo \
    php8-opcache \
    php8-zip \
    php8-phar \
    php8-iconv \
    php8-cli \
    php8-curl \
    php8-openssl \
    php8-mbstring \
    php8-tokenizer \
    php8-fileinfo \
    php8-json \
    php8-xml \
    php8-xmlwriter \
    php8-simplexml \
    php8-dom \
    php8-pdo_mysql \
    php8-pdo_sqlite \
    php8-tokenizer \
    php8-pecl-redis

# Symlinking php8 to php
RUN ln -s /usr/bin/php8 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
	&& php8 composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& rm -rf composer-setup.php

# Configure php-fpm
COPY .docker/php-fpm.conf /etc/php8/php-fpm.conf
COPY .docker/fastcgi-php.conf /etc/nginx/fastcgi-php.conf

RUN mkdir -p /run/php/ \
	&& touch /run/php/php8.0-fpm.pid \
	&& touch /run/php/php8.0-fpm.sock

# Configure nginx
COPY .docker/default.conf /etc/nginx/conf.d/default.conf

RUN echo "daemon off;" >> /etc/nginx/nginx.conf \
	&& mkdir -p /run/nginx/ && touch /run/nginx/nginx.pid \
	&& ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY .docker/supervisord.ini /etc/supervisor.d/supervisord.ini

# Building process
COPY . .
RUN composer install --no-dev

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]
