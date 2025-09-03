FROM php:8.2-cli

# Системные зависимости
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . /var/www

# Устанавливаем зависимости Laravel сразу при сборке
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
