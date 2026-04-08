# ==============================
# Stage 1 : Build des dépendances
# ==============================
FROM composer:2.6 AS build

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize --no-scripts

# ==============================
# Stage 2 : Image de production
# ==============================
FROM php:8.2-fpm-alpine

# Extensions PHP nécessaires pour Laravel
RUN apk add --no-cache \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

WORKDIR /var/www/html

# Copier l'application depuis le stage build
COPY --from=build /app /var/www/html

# Créer dossiers nécessaires Laravel
RUN mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

# Sécurité : utilisateur non-root
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www && \
    chown -R www:www /var/www/html

USER www

EXPOSE 9000

CMD ["php-fpm"]
