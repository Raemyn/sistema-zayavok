# Система заявок

## Быстрый старт (Docker)

Склонируйте репозиторий и запустите проект:

```bash
git clone https://github.com/Raemyn/sistema-zayavok
cd sistema-zayavok
docker-compose up -d
docker exec -it sistema-app php artisan migrate --seed
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

## Получение токена (для админ-эндпоинтов)

1. Зарегистрируйтесь через API:

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

2. Войдите и получите токен:

```bash
curl -X POST http://localhost:8000/api/auth/login \
-H "Content-Type: application/json" \
-d '{"email":"admin@test.com","password":"password"}'
```

- В ответе будет поле `token`. Этот токен используется для всех админ-эндпоинтов:

```http
Authorization: Bearer <ваш_токен>
```

---

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
curl -X POST http://localhost:8000/api/leads \
-H "Content-Type: application/json" \
-d '{"name":"Иван","email":"ivan@test.com","message":"Тест"}'
```

2. Получить список заявок (админ):

```bash
curl -X GET http://localhost:8000/api/leads \
-H "Authorization: Bearer <ваш_токен>"
```

3. Создать комментарий к заявке:

```bash
curl -X POST http://localhost:8000/api/leads/1/comments \
-H "Authorization: Bearer <ваш_токен>" \
-H "Content-Type: application/json" \
-d '{"body":"Первый комментарий"}'
```

---

## Сброс и повторный запуск

Если нужно полностью очистить базу и запустить заново:

```bash
docker-compose down -v
docker-compose up -d
docker exec -it sistema-app php artisan migrate --seed
```

# Готово!
Теперь проверяющий может сразу поднять проект, зайти в базу, получить токен и протестировать все эндпоинты.

