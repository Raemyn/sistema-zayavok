# Система заявок

## Быстрый старт (Docker)


Склонируйте репозиторий и запустите проект:

```bash
git clone https://github.com/Raemyn/sistema-zayavok
cd sistema-zayavok
docker-compose up --build -d
docker exec -it sistema-app php artisan migrate:fresh
# Проект будет доступен на http://localhost:8000
```

---

## Доступ к базе данных

- phpMyAdmin: http://localhost:8080
- Host: db
- User: laravel
- Password: laravel
- Database: sistema_zayavok

---

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
    name = "Иван"
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
    name = "Иван"
    email = "ivan@test.com"
    message = "Тестовое сообщение"
} | ConvertTo-Json)

```

2. Получить список заявок (админ):

```bash
Invoke-RestMethod -Uri http://localhost:8000/api/leads `
-Method GET `
-Headers @{
    "Accept" = "application/json"
    "Authorization" = "Bearer Ваш_токен_без_кавычек"
}
```

3. Создать комментарий к заявке (админ):

```bash
curl -X POST http://localhost:8000/api/leads/1/comments \
-H "Authorization: Bearer <ваш_токен>" \
-H "Content-Type: application/json" \
-d '{"body":"Первый комментарий"}'
```

---

## Сброс и повторный запуск

Если нужно очистить таблицы:

```bash
docker exec -it sistema-app php artisan migrate:fresh
```


