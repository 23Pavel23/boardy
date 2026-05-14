# Практика 12: Laravel (MVC + Breeze + Socialite)

## Часть A. Установка и переключение домена

### Задание 1. Composer и PHP-расширения
![01-composer-php](screenshots/01-composer-php.png)

### Задание 2. Переезд папок
![02-folders](screenshots/02-folders.png)

### Задание 3. Laravel версия
![03-laravel-version](screenshots/03-laravel-version.png)

### Задание 4. Nginx конфиг
![04-nginx-config](screenshots/04-nginx-config.png)

### Задание 5. Приветственная страница
![05-laravel-welcome](screenshots/05-laravel-welcome.png)

**Почему document_root указывает на public/?**
Чтобы скрыть исходный код и конфиги от внешнего мира. Только public/ доступен извне.

## Часть B. БД, миграции, сидер

### Задание 6. Создание БД
![06-databases](screenshots/06-databases.png)

### Задание 7. Подключение к БД
![07-tinker-pdo](screenshots/07-tinker-pdo.png)

### Задание 8. Миграции
![08-migrate-status](screenshots/08-migrate-status.png)
![09-show-tables](screenshots/09-show-tables.png)

### Задание 9. Модели со связями
![10-model-relations](screenshots/10-model-relations.png)

### Задание 10. Сидер
![11-seed-counts](screenshots/11-seed-counts.png)

## Часть C. CRUD постов и комментариев

### Задание 11. Маршруты
![12-route-list](screenshots/12-route-list.png)

### Задание 12. Лента постов
![13-posts-index](screenshots/13-posts-index.png)

### Задание 13. Страница поста
![14-post-show](screenshots/14-post-show.png)

### Задание 14. Создание поста
![15-post-create](screenshots/15-post-create.png)
![16-post-after-create](screenshots/16-post-after-create.png)

### Задание 15. Policy
![17-edit-own](screenshots/17-edit-own.png)
![18-edit-foreign-403](screenshots/18-edit-foreign-403.png)

### Задание 16. Удаление поста
![19-post-deleted](screenshots/19-post-deleted.png)

### Задание 17. Комментарии
![20-comment-created](screenshots/20-comment-created.png)

## Часть D. Breeze + Socialite

### Задание 18. Breeze
![21-register](screenshots/21-register.png)
![22-login](screenshots/22-login.png)
![23-after-register](screenshots/23-after-register.png)

### Задание 19. GitHub OAuth
![24-github-app](screenshots/24-github-app.png)
![25-login-with-github](screenshots/25-login-with-github.png)
![26-github-authorize](screenshots/26-github-authorize.png)
![27-after-github-login](screenshots/27-after-github-login.png)
![28-mysql-github-id](screenshots/28-mysql-github-id.png)

## Часть E. Архитектурные вопросы

### Вопрос 22. Что осталось от прошлых практик?
Старый PHP-проект в `/var/www/boardy-legacy` и БД `boardy` остались как исторический артефакт. При попытке открыть `login.php` будет 404, потому что Nginx теперь указывает на `public/` Laravel.

### Вопрос 23. FastAPI и React
Сейчас не используем, потому что Laravel рендерит посты и комментарии через Blade. В Lab13 они пригодятся — FastAPI станет BFF, React вернётся на страницу поста.

### Вопрос 24. Реалтайм
Нужен WebSocket (Laravel Reverb или Pusher). Два сервера-кандидата: Laravel (publish события) и Node.js (WebSocket сервер).
