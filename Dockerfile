FROM php:8.2-cli

# Системные зависимости
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libonig-dev libxml2-dev libpng-dev \
 && docker-php-ext-install pdo_mysql zip \
 && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем весь код сразу (чтобы artisan был доступен)
COPY . .

# Устанавливаем зависимости
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Открываем порт
EXPOSE 8000
