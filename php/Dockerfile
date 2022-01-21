FROM php:7.4.14-cli-alpine

MAINTAINER zhangxing@kingsoft.com

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
        && apk update \
        && apk upgrade

# Common
RUN apk add icu-dev \
    gcc \
    openssl \
    git \
    gnupg \
    curl \
    openssl-dev \
    autoconf \
    g++\
    make \
    dpkg-dev dpkg \
    libc-dev \
    pkgconf


# compression
RUN apk add bzip2-dev \
    libbz2 \
    zlib-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) \
        zip \
        bz2

# database
RUN docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql

RUN apk add openssl-dev \
    && docker-php-ext-install -j$(nproc) \
        ftp

# iconv
RUN set -ex \
  && apk add --no-cache \
    gnu-libiconv \
    php7-iconv

# images
RUN apk add libpng \
    freetype \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    gd \
    gd-dev \
    && docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
        gd \
        exif
RUN apk add imagemagick-dev libtool \
    && pecl install imagick-3.4.4 \
    && docker-php-ext-enable imagick

# imap
RUN apk add imap-dev \
    krb5-dev \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# intl
RUN apk add icu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl

# ldap
RUN apk add ldb-dev libldap openldap-dev \
    && docker-php-ext-install ldap

# math
RUN apk add gmp-dev \
    && docker-php-ext-install -j$(nproc) \
        gmp \
        bcmath

# mcrypt
RUN apk add \
    $PHPIZE_DEPS \
    openssl-dev \
    libmcrypt-dev \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt

# mongodb
RUN pecl install mongodb-1.9.0 \
    && docker-php-ext-enable mongodb

# pdo_sqlsrv
RUN apk add unixodbc-dev \
    && pecl install sqlsrv pdo_sqlsrv-5.9.0 \
    && docker-php-ext-enable pdo_sqlsrv

# redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# ssh2
RUN apk add libssh2-dev

# strings
RUN apk add gettext-dev \
    && docker-php-ext-install -j$(nproc) \
        gettext

# xml
RUN apk add libxml2-dev \
    libxslt-dev \
    && docker-php-ext-install -j$(nproc) \
        dom \
        xmlrpc \
        xsl

# xlswriter
RUN pecl install xlswriter \
    && docker-php-ext-enable xlswriter

# others
RUN docker-php-ext-install -j$(nproc) \
        calendar \
        dba \
        opcache \
        pcntl \
        shmop \
        soap \
        sockets \
        sysvmsg \
        sysvsem \
        sysvshm




# Clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*

RUN set -eux; \
    addgroup -g 1000 -S www; \
    adduser www -D -G www -u 1000 -S

RUN chown -R www:www /tmp \
    && mkdir -p /data/www \
    && chown -R www:www /data/www

USER www