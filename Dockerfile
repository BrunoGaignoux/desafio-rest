FROM php:7.3-fpm-alpine

LABEL maintainer "Bruno Gaignoux <gaignoux@gmail.com>"

ARG ARG_ENVIRONMENT=local
ENV ENVIRONMENT=$ARG_ENVIRONMENT

RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories

RUN apk update && apk --no-cache add \
  curl-dev \
  git \
  libxml2-dev \
  shadow \
  zlib-dev \
  libzip-dev \
  libpng-dev

RUN docker-php-ext-install \
  curl \
  mbstring \
  pdo_mysql \
  xml \
  xmlrpc \
  zip \
  gd

RUN apk update && apk --no-cache add \
  nginx \
  supervisor

RUN mkdir /var/run/php-fpm \
  && mkdir /var/log/php-fpm \
  && chmod 0777 /var/log/php-fpm

RUN rm -f /usr/local/etc/php-fpm.d/*.conf

RUN if [ "$ARG_ENVIRONMENT" != "local" ] ; then  curl -L https://download.newrelic.com/php_agent/archive/8.6.0.238/newrelic-php5-8.6.0.238-linux-musl.tar.gz | tar -C /tmp -zx && NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_SILENT=1 /tmp/newrelic-php5-*/newrelic-install install; fi

# Copy OS wide resource configuration files
COPY docker/resources/ /

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files (Files are changed between builds so docker cache won't be used for subsequent layers)
COPY . /opt/user-manager
WORKDIR /opt/user-manager

EXPOSE 80

CMD /opt/user-manager/docker/start.sh