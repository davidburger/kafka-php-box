FROM php:7.1-apache

ARG LIBRDKAFKA=${LIBRDKAFKA:-'v0.9.5'}

RUN  apt-get update && apt-get install -y build-essential ca-certificates \
 git curl libcurl3 libcurl3-dev \
 openssl tar \
 zlib1g-dev \
 unzip \
 python3
# librdkafka-dev

RUN update-alternatives --install /usr/bin/python python /usr/bin/python3.4 1

RUN cd /tmp && \
 git clone -b "$LIBRDKAFKA" --single-branch --depth 1 https://github.com/edenhill/librdkafka && \
 cd librdkafka && \
 ./configure && make && make install && \
 rm -rf /tmp/librdkafk*

RUN docker-php-ext-install zip

RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka

RUN rm -rf /var/lib/apt/lists/*

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer


#reduce image size
RUN apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false python3
RUN apt-get autoremove -y
RUN apt-get clean
RUN apt-get autoclean

WORKDIR /var/www/html