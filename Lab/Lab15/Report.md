# Практика 15: Docker и Docker Compose

## Часть A. Dockerfile для Laravel

### Задание 1. PHP-FPM с расширениями
PHP-FPM используется вместо Apache — разделение ответственности. Nginx сам решает когда передать запрос PHP процессу, что даёт лучшую производительность.
![01-laravel-build](screenshots/01-laravel-build.png)

### Задание 2. Кеширование composer-зависимостей
Если COPY всего проекта сделать ДО composer install — при любом изменении кода Docker пересобирает слой зависимостей заново. При правильном порядке слой кешируется.
![02-composer-layer](screenshots/02-composer-layer.png)

### Задание 3. .dockerignore
Если не исключить .env — пароли и секретные ключи попадут внутрь образа и могут утечь через Docker Hub.
![03-dockerignore](screenshots/03-dockerignore.png)

## Часть Б. Dockerfile для FastAPI

### Задание 4. requirements.txt
Версии фиксируем чтобы через год pip install не сломал приложение обновлением с breaking changes.
![04-requirements](screenshots/04-requirements.png)

### Задание 5. Сборка образа
![05-fastapi-build](screenshots/05-fastapi-build.png)

### Задание 6. CMD с правильным host
С --host 127.0.0.1 uvicorn слушает только внутри контейнера. Другие контейнеры не могут достучаться. --host 0.0.0.0 открывает все интерфейсы.
![06-uvicorn-cmd](screenshots/06-uvicorn-cmd.png)

## Часть В. Конфиг Nginx

### Задание 7. docker/nginx/default.conf
laravel:9000 — имя контейнера из docker-compose. Docker резолвит имена контейнеров через встроенный DNS внутри сети boardy_net.
![07-nginx-conf](screenshots/07-nginx-conf.png)

### Задание 8. WebSocket location
proxy_http_version 1.1, Upgrade и Connection "upgrade" обязательны для WebSocket. proxy_read_timeout 86400 держит соединение 24 часа.
![08-ws-config](screenshots/08-ws-config.png)

## Часть Г. docker-compose.yml

### Задание 9. Пять сервисов
![09-compose-services](screenshots/09-compose-services.png)

### Задание 10. Volumes
Без mysql_data volume данные MySQL удалятся при docker compose down. Именованный volume хранится в Docker, bind-mount — папка на хосте.
![10-volumes](screenshots/10-volumes.png)

### Задание 11. Healthcheck для MySQL и Redis
depends_on без healthcheck не гарантирует что MySQL готов принимать подключения — контейнер может быть запущен но MySQL ещё инициализируется. Возникает race condition.
![11-healthcheck](screenshots/11-healthcheck.png)

### Задание 12. init.sql для двух БД
init.sql выполняется только при первом запуске — когда volume пустой. При повторных запусках volume уже инициализирован и файл игнорируется.
![12-init-sql](screenshots/12-init-sql.png)
![13-databases-created](screenshots/13-databases-created.png)

### Задание 13. Два .env файла
Корневой .env — переменные для docker-compose (пароли БД). boardy-laravel/.env — переменные Laravel. DB_HOST=mysql потому что внутри сети Docker имя контейнера резолвится в IP.
![14-env-compose](screenshots/14-env-compose.png)
![15-env-laravel](screenshots/15-env-laravel.png)

## Часть Д. Запуск и проверка

### Задание 14. docker compose up
![16-compose-up](screenshots/16-compose-up.png)

### Задание 15. Миграции в контейнере
docker compose exec выполняет команду в уже запущенном контейнере. docker compose run создаёт новый временный контейнер.
![17-migrate](screenshots/17-migrate.png)
![18-passport-install](screenshots/18-passport-install.png)

### Задание 16. Приложение работает
![19-app-running](screenshots/19-app-running.png)
![20-comment-works](screenshots/20-comment-works.png)

### Задание 17. Реалтайм работает
![21-realtime-posts](screenshots/21-realtime-posts.png)
![22-realtime-comments](screenshots/22-realtime-comments.png)

### Задание 18. Данные переживают перезапуск
docker compose down -v удаляет volumes вместе с данными. Без -v данные сохраняются в именованных volumes.
![23-persist](screenshots/23-persist.png)

### Задание 19. Централизованные логи
Docker собирает логи всех сервисов в одном месте. Не нужно заходить на сервер и искать /var/log/* для каждого сервиса отдельно.
![24-logs](screenshots/24-logs.png)

### Задание 20. Чистая машина
Команда от клона до рабочего приложения: git clone → docker compose up -d
![25-fresh-install](screenshots/25-fresh-install.png)
