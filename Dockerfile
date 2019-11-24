#BASE
FROM alpine:3.9 as base

RUN apk update \
&&  apk add php7-pdo_pgsql php7-mbstring php7-tokenizer php7-xml php7-json  php7-iconv php7-bcmath php7-dom \
            php7-xmlwriter

#DEPENDENCIES
FROM base as studocu

WORKDIR /studocu
COPY . /studocu

RUN apk add composer php7-curl php7-zip \
&&  composer global require hirak/prestissimo \
&&  composer install --no-dev --no-interaction

#CLI
FROM studocu as dev
RUN composer install
