FROM php:8.2.2-fpm

RUN rm /etc/apt/preferences.d/no-debian-php && \
    apt-get update && \
    apt-get -y install --no-install-recommends curl php-bcmath git wget zip unzip \
    libpng-dev libpq-dev libxml2-dev libssl-dev libcurl4-openssl-dev libzip-dev libonig-dev zlib1g-dev \
    librabbitmq-dev \
    libssh-dev && \
    docker-php-ext-install bcmath curl xml mbstring zip pgsql pdo pdo_pgsql pdo_mysql intl soap gd sockets pcntl opcache && \
    pecl install amqp && docker-php-ext-enable amqp

ENV FPM_PM_MAX_CHILDREN="10" \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="1" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_REALPATH_CACHE_TTL="120"
COPY .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"

WORKDIR /var/www/blog-src/

# Install composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug
RUN echo "xdebug.mode=debug,coverage\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    "xdebug.start_with_request=yes\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    "xdebug.discover_client_host=1\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    "xdebug.client_host=\"host.docker.internal\"\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN docker-php-ext-enable xdebug

# Install pcov for code coverage (compatible phunit ^8)
RUN pecl install pcov && docker-php-ext-enable pcov && echo "extension=pcov.so" >> /usr/local/etc/php/php.ini

# Install infection
RUN wget https://github.com/infection/infection/releases/download/0.26.17/infection.phar \
    && chmod +x infection.phar \
    && mv infection.phar /usr/local/bin/infection

# Install deptrac
RUN wget https://github.com/qossmic/deptrac/releases/download/1.0.2/deptrac.phar \
    && chmod +x deptrac.phar \
    && mv deptrac.phar /usr/local/bin/deptrac
