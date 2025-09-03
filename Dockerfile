FROM php:8.2-cli

# Системные зависимости
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libonig-dev libxml2-dev libpng-dev \
 && docker-php-ext-install pdo_mysql zip \
 && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www

# Копируем только файлы зависимостей сначала (оптимизация сборки)
COPY composer.json composer.lock ./

# Устанавливаем зависимости на этапе билда
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Копируем весь код приложения
COPY . .

# Открываем порт для Laravel
EXPOSE 8000
