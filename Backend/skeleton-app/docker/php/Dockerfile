FROM php:8.3.2RC1-fpm-alpine3.19

RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS libpng-dev libzip-dev rabbitmq-c rabbitmq-c-dev linux-headers \
    ; \
    apk add --no-cache bash openssl tzdata unzip; \
    pecl install redis amqp; \
    docker-php-ext-enable redis amqp; \
    docker-php-ext-install pcntl pdo pdo_mysql gd zip exif sockets; \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache $runDeps; \
    apk del --no-network .build-deps

COPY docker/php-fpm/custom.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY docker/php/config/config.ini /usr/local/etc/php/conf.d/zzz-custom-config.ini

RUN addgroup -g 1000 php-app && adduser -G php-app -s /bin/bash -D php-app

WORKDIR /home/php-app/application

COPY --chown=php-app:php-app . /home/php-app/application

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/php/entrypoints/custom.sh /usr/local/bin/custom-docker-entrypoint

ENTRYPOINT ["custom-docker-entrypoint"]

CMD ["php-fpm"]
