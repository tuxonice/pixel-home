#
# Application
#
FROM php:7.4-apache-buster

RUN apt-get update && apt-get install -y \
    imagemagick \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libxslt-dev \
    vim \
    wget \
    unzip \
    git \
    libzip-dev \
    libbz2-dev \
    zlib1g-dev \
    libssh2-1-dev \
    msmtp \
    gnupg2 \
    iproute2 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install -j$(nproc) zip iconv intl xml soap opcache pdo pdo_mysql mysqli bz2 exif xsl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug

ENTRYPOINT ["entrypoint"]

RUN echo "ServerName $(/sbin/ip route|awk '/default/ { print $3 }')" >> /etc/apache2/apache2.conf
RUN echo 'alias ll="ls -la"' >> /root/.bashrc

COPY docker/application/disable-xdebug.sh /disable-xdebug.sh
COPY docker/application/enable-xdebug.sh /enable-xdebug.sh
COPY docker/application/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /disable-xdebug.sh /enable-xdebug.sh /usr/local/bin/entrypoint

# configure php.ini settings
COPY docker/application/php-config.ini /usr/local/etc/php/conf.d/php-config.ini

COPY docker/application/localhost.conf /etc/apache2/sites-available/localhost.conf

RUN a2dissite 000-default.conf \
    && a2dissite default-ssl.conf \
    && a2ensite localhost.conf \
    && a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
CMD ["apache2-foreground"]
