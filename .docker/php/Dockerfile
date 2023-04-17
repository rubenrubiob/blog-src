FROM php:8.2.4-fpm

RUN rm /etc/apt/preferences.d/no-debian-php && \
    apt-get update && \
    apt-get -y install --no-install-recommends curl git wget zip unzip \
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
COPY .docker/php/opcache.ini "$PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini"

WORKDIR /var/www/blog-src/

# Install composer
COPY --from=composer/composer:2-bin /composer /usr/local/bin/composer

# Install xdebug
RUN pecl install xdebug
COPY .docker/php/xdebug.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini"

# Install pcov for code coverage (compatible phunit ^8)
RUN pecl install pcov && docker-php-ext-enable pcov && echo "extension=pcov.so" >> /usr/local/etc/php/php.ini

# Install infection
RUN wget https://github.com/infection/infection/releases/download/0.26.19/infection.phar \
    && chmod +x infection.phar \
    && mv infection.phar /usr/local/bin/infection

# Install deptrac
RUN wget https://github.com/qossmic/deptrac/releases/download/1.0.2/deptrac.phar \
    && chmod +x deptrac.phar \
    && mv deptrac.phar /usr/local/bin/deptrac

# Install ComposerRequireChecker
RUN wget https://github.com/maglnet/ComposerRequireChecker/releases/download/4.5.0/composer-require-checker.phar \
    && chmod +x composer-require-checker.phar \
    && mv composer-require-checker.phar /usr/local/bin/composer-require-checker

# Install ComposerUnused
RUN wget https://github.com/composer-unused/composer-unused/releases/download/0.8.7/composer-unused.phar \
    && chmod +x composer-unused.phar \
    && mv composer-unused.phar /usr/local/bin/composer-unused
