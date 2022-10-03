ARG PHP_TAG=php:8.0-fpm-alpine

FROM ${PHP_TAG} AS app_php

RUN echo "UTC" > /etc/timezone

COPY --from=composer:2.1.14 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/app

COPY composer.* ./

COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]

CMD ["php-fpm"]