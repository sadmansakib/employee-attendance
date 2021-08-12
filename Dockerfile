FROM php:7.1-alpine

RUN apk add bash

# installing composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql

# Running
WORKDIR /app
COPY . .
COPY start.sh .
COPY wait-for .

RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 8000
ENTRYPOINT [ "/app/start.sh" ]
