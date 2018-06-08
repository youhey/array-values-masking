FROM php:7.2-cli-alpine

RUN apk add --update --no-cache \
        unzip \
        git \
    && rm -rf /var/cache/apk/*

#--------------------------------------------------------------------------
# PHP Composer
#--------------------------------------------------------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#--------------------------------------------------------------------------
# working
#--------------------------------------------------------------------------
RUN mkdir /work
VOLUME /work
WORKDIR /work

RUN addgroup php \
    && adduser -h /home/php -s /bin/bash -G php -D php \
    && mkdir -p /home/php \
    && chown -R php:php /home/php

USER php

ENV HOME /home/php
ENV TERM xterm
ENV LANG C.UTF-8
