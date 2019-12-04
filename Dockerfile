#BASE
FROM alpine:edge as base

RUN apk update \
&&  apk add php7-pdo_pgsql php7-mbstring php7-tokenizer php7-xml php7-json  php7-iconv php7-bcmath php7-dom \
            php7-xmlwriter php7-session

#DEPENDENCIES
FROM base as studocu

WORKDIR /studocu
COPY . /studocu

RUN apk add composer php7-curl php7-zip \
&&  composer global require hirak/prestissimo \
&&  composer install --no-dev --no-interaction

#CLI
FROM studocu as dev
RUN apk add php7-pecl-pcov --repository=http://dl-cdn.alpinelinux.org/alpine/edge/testing \
    && composer install
