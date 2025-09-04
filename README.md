# Система заявок

## Быстрый старт (Docker)


Склонируйте репозиторий и запустите проект:
команды в powershell
```bash
git clone https://github.com/Raemyn/sistema-zayavok
cd sistema-zayavok
docker-compose up --build -d
# Проект будет доступен на http://localhost:8000/api/
```

---

## Доступ к базе данных

- phpMyAdmin: http://localhost:8080
- Host: db
- User: laravel
- Password: laravel
- Database: sistema_zayavok

---
## Адаптивный интерфейс с Blade и Vue 3.




# Адаптивный интерфейс с Blade и Vue 3

## Цель
Управление заявками через админку с отображением комментариев и редактированием статусов.

| Возможность | Что проверять | Ссылка/Маршрут |
|------------|---------------|----------------|
| Вход в админку | Авторизация через email и пароль | `/admin/login`<br>**Email:** `admin@example.com`<br>**Пароль:** `admin` |
| Просмотр списка заявок | Все заявки отображаются с именем, email, телефоном и сообщением | `/admin/leads` |
| Редактирование статуса заявки | Статус можно менять через выпадающий список; после изменения значение сохраняется в базе | `/admin/leads` (выпадающий список у каждой заявки) |
| Просмотр комментариев | Под каждой заявкой отображаются комментарии с автором и текстом | `/admin/leads` (список комментариев под заявкой) |
| Адаптивность интерфейса | Корректное отображение на десктопе и мобильных устройствах | Любое устройство/браузер |



## Токен можно получить двумя способами: через регистрацию нового пользователя или вход существующего.

1. Регистрация нового пользователя через API:

```bash
Invoke-RestMethod -Uri http://localhost:8000/api/auth/register `
-Method POST `
-Headers @{
    "Accept" = "application/json"
    "Content-Type" = "application/json"
} `
-Body (@{
    name = "Ivan"
    email = "ivan1@test.com"
    password = "password"
    password_confirmation = "password"
} | ConvertTo-Json)

```

2. Вход существующего пользователя:

```bash
Invoke-RestMethod -Uri http://localhost:8000/api/auth/login `
-Method POST `
-Headers @{
    "Accept" = "application/json"
    "Content-Type" = "application/json"
} `
-Body (@{
    email = "ivan1@test.com"
    password = "password"
} | ConvertTo-Json)

```

## Краткий список эндпоинтов

### Публичные (без токена)

- `POST /api/leads` — создать заявку

### Админ (Bearer-токен)

- `GET /api/leads` — список заявок  
- `GET /api/leads/{id}` — просмотр заявки  
- `PUT /api/leads/{id}` — обновление (в том числе status, source_id)  
- `DELETE /api/leads/{id}` — soft delete  
- `GET /api/leads/{id}/comments` — список комментариев  
- `POST /api/leads/{id}/comments` — создать комментарий  
- `DELETE /api/comments/{id}` — удалить комментарий  
- `GET /api/sources` — список источников  
- `POST /api/sources` — создать источник  
- `PUT /api/sources/{id}` — обновить источник  
- `DELETE /api/sources/{id}` — удалить источник

---

## Примеры curl

1. Создать заявку (публичный):

```bash
 Invoke-RestMethod -Uri http://localhost:8000/api/leads `
-Method POST `
-Headers @{
    "Accept" = "application/json"
    "Content-Type" = "application/json"
} `
-Body (@{
    name = "Ivan"
    email = "ivan@test.com"
    message = "text message"
} | ConvertTo-Json)
                                                                                                    
```

2. Получить список заявок (админ):

```bash
Invoke-RestMethod -Uri http://localhost:8000/api/leads `
-Method GET `
-Headers @{
    "Accept" = "application/json"
    "Authorization" = "Bearer Ваш_токен_без_кавычек"
} | ConvertTo-Json
```

3. Создать источник (админ):

```bash
Invoke-RestMethod -Uri http://localhost:8000/api/sources `
-Method POST `
-Headers @{
    "Authorization" = "Bearer Ваш_токен_без_кавычек"
    "Accept"        = "application/json"
    "Content-Type"  = "application/json"
} `
-Body (@{
    name = "Instagram"
} | ConvertTo-Json -Depth 3)
```

---

## Сброс и повторный запуск

Если нужно очистить таблицы:

```bash
docker exec -it sistema-app php artisan migrate:fresh
```


