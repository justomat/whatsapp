FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    redis \
    pdo_pgsql \
    pgsql \
    uv

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
