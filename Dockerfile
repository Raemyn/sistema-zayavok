FROM php:8.2-cli

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем код проекта
COPY . /var/www

# Устанавливаем зависимости Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
