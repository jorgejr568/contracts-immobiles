FROM node:latest as mix
WORKDIR /mix

COPY . .

RUN yarn install
RUN yarn prod

FROM php:7.4
RUN apt-get update -y && apt-get install -y openssl zip unzip git libonig-dev libzip-dev libpq-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring exif zip pgsql pdo_pgsql
WORKDIR /app
COPY --from=mix /mix/public /app/public
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
