# Практика 14: Финальная микросервисная архитектура

## Часть A. Passport как OAuth 2.1 сервер

### Задание 1. Установка и SPA-клиент
![01-passport-install](screenshots/01-passport-install.png)
![02-spa-client](screenshots/02-spa-client.png)

### Задание 2. TTL и refresh
![03-token-ttl](screenshots/03-token-ttl.png)

### Задание 3. Проверка выдачи через curl
![04-pkce-curl](screenshots/04-pkce-curl.png)

## Часть Б. Две базы данных

### Задание 4. Создание boardy_api
![05-databases](screenshots/05-databases.png)
![06-comments-schema](screenshots/06-comments-schema.png)

### Задание 5. FastAPI подключён к новой БД
![07-fastapi-db](screenshots/07-fastapi-db.png)

## Часть В. FastAPI: RS256 + полный CRUD

### Задание 6. RS256 проверка
![08-rs256-success](screenshots/08-rs256-success.png)
![09-rs256-fail](screenshots/09-rs256-fail.png)

### Задание 7. Полный CRUD с author_name
![10-crud-all](screenshots/10-crud-all.png)

### Задание 8. Owner check
![11-owner-check](screenshots/11-owner-check.png)

### Задание 9. CORS
![12-cors-config](screenshots/12-cors-config.png)

## Часть Г. React PKCE flow

### Задание 10. PKCE утилиты
![13-pkce-utils](screenshots/13-pkce-utils.png)

### Задание 11. Login flow
![14-login-redirect](screenshots/14-login-redirect.png)
![15-login-callback](screenshots/15-login-callback.png)

### Задание 12. Обмен code на токены
![16-token-exchange](screenshots/16-token-exchange.png)

### Задание 13. Refresh token в HttpOnly cookie
![17-refresh-cookie](screenshots/17-refresh-cookie.png)

### Задание 14. Silent refresh
![18-silent-refresh](screenshots/18-silent-refresh.png)

## Часть Д. Redis Pub/Sub

### Задание 15. Redis установлен
![19-redis-ping](screenshots/19-redis-ping.png)

### Задание 16. Laravel publish new_post
![20-laravel-publish](screenshots/20-laravel-publish.png)

### Задание 17. FastAPI subscriber на new_post
![21-subscriber-running](screenshots/21-subscriber-running.png)
![22-broadcast-flow](screenshots/22-broadcast-flow.png)

### Задание 18. User observer и user.renamed
![23-user-renamed](screenshots/23-user-renamed.png)

### Задание 19. Денормализация имени
![24-denorm-before](screenshots/24-denorm-before.png)
![25-denorm-after](screenshots/25-denorm-after.png)

## Часть Е. Финальные проверки

### Задание 20. Два браузера: посты в реалтайме
![26-two-browsers-post](screenshots/26-two-browsers-post.png)

### Задание 21. Два браузера: комментарии в реалтайме
![27-two-browsers-comment](screenshots/27-two-browsers-comment.png)

### Задание 22. Никаких прямых HTTP-вызовов
![28-no-http-callback](screenshots/28-no-http-callback.png)
![29-nginx-no-internal](screenshots/29-nginx-no-internal.png)
