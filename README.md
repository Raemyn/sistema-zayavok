## Быстрый старт

Склонируйте репозиторий и установите зависимости:

```bash
git clone https://github.com/Raemyn/sistema-zayavok
cd sistema-zayavok
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve