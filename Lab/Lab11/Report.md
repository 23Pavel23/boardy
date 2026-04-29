# Практика 11: JWT для API и OAuth через GitHub

## Часть A. JWT для API

### Задание 1. auth.py

![01-no-token](screenshots/01-no-token.png)

**Что означает «Bearer» в заголовке Authorization?**

«Bearer» — это схема аутентификации, указывающая, что токен является «bearer token». Любой, кто владеет этим токеном, может получить доступ к ресурсу. Префикс нужен, чтобы сервер понимал тип токена.

### Задание 2. /api/me.php

![02-me-php](screenshots/02-me-php.png)

**Почему me.php использует session_start()?**

`session_start()` читает PHP-сессию по куке `PHPSESSID`. Это безопаснее, чем передавать логин/пароль каждый раз.

### Задание 3. React получает JWT

![03-console-jwt](screenshots/03-console-jwt.png)

### Задание 4. Bearer в запросах

![04-bearer-header](screenshots/04-bearer-header.png)

### Задание 5. Комментарий создан

![05-comment-created](screenshots/05-comment-created.png)

### Задание 6. jwt.io

![06-jwt-io](screenshots/06-jwt-io.png)

**Payload зашифрован или закодирован?**

Payload только закодирован в base64, не зашифрован. Злоумышленник может прочитать `user_id`, `name`, `exp`. Это не проблема, так как данные не секретные. Главная защита — подпись.

### Задание 7. Истёкший токен

![07-expired](screenshots/07-expired.png)

### Задание 8. Невалидный токен

![08-invalid](screenshots/08-invalid.png)

## Часть B. OAuth через GitHub

### Задание 9. OAuth App на GitHub

![09-github-app](screenshots/09-github-app.png)

### Задание 10. Столбец github_id

![10-describe](screenshots/10-describe.png)

### Задание 11. Кнопка «Войти через GitHub»

![11-login-button](screenshots/11-login-button.png)

### Задание 12. Экран авторизации GitHub

![12-github-authorize](screenshots/12-github-authorize.png)

### Задание 13. После входа через GitHub

![13-oauth-logged](screenshots/13-oauth-logged.png)

### Задание 14. github_id в базе

![14-github-user](screenshots/14-github-user.png)

**Почему ищем по github_id, а не по email?**

`github_id` — уникальный и постоянный идентификатор. Email может измениться или отсутствовать.

### Задание 15. Комментарий от GitHub пользователя

![15-oauth-comment](screenshots/15-oauth-comment.png)

**Полный flow:**

1. Кнопка «Войти через GitHub» → редирект на GitHub
2. Пользователь нажимает Authorize
3. GitHub редиректит с code
4. Обмен code на access_token
5. Запрос профиля пользователя
6. Поиск/создание пользователя по github_id
7. Создание сессии
8. React получает JWT через /api/me.php
9. Отправка комментария с Bearer токеном
10. FastAPI создаёт комментарий

### Задание 16. Три способа входа

![16-three-users](screenshots/16-three-users.png)

## Часть C. Анализ

### Задание 17. Сравнение механизмов

| Вопрос | Куки+сессии | JWT | OAuth |
|--------|-------------|-----|-------|
| Где хранятся данные? | На сервере | В токене | У провайдера |
| Кто прикрепляет к запросу? | Браузер | Клиент | GitHub |
| Для какого типа клиентов? | Браузер | API, кросс-домен | Внешние сервисы |
| Можно ли отозвать? | Да | Нет | Да |
| Кросс-доменно работает? | Нет | Да | Да |

### Задание 18. Баги и пакеты

Три бага в моём коде:

| Баг | Опасность | Решение |
|-----|-----------|---------|
| Секретный ключ в коде | Утечка через git | Переменные окружения |
| Нет отзыва токенов | Токен работает после блокировки | Passport |
| Нет refresh токенов | Истёк JWT → логин заново | Passport |
