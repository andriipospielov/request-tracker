FROM php:7.2-fpm

RUN echo Europe/Kiev | tee /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata; \
    echo "date.timezone=Europe/Kiev" >> /usr/local/etc/php/conf.d/zzz.ini; \
    echo "realpath_cache_size=4096k" >> /usr/local/etc/php/conf.d/zzz.ini; \
    echo "realpath_cache_ttl=7200" >> /usr/local/etc/php/conf.d/zzz.ini; \
    echo "memory_limit=8192M" >> /usr/local/etc/php/conf.d/zzz.ini;

RUN apt-get update \
    && apt-get -qqy install \
        zlib1g-dev \
        git \
        netcat \

    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN docker-php-ext-install \
        zip \
        mbstring \
        pdo_mysql \
        bcmath \
        opcache

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer selfupdate -q

WORKDIR "/code"
COPY . ./
VOLUME "/code"
