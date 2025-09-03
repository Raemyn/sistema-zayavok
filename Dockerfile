FROM php:8.2-cli

# Системные зависимости
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libonig-dev libxml2-dev libpng-dev \
 && docker-php-ext-install pdo_mysql zip \
 && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Кладём код в образ (на dev он будет перекрыт volume'ом — это нормально)
COPY . /var/www

# Пробуем поставить зависимости на этапе билда (не критично, поэтому || true)
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader || true

EXPOSE 8000
