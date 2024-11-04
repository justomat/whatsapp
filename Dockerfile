FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    redis \
    uv

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
