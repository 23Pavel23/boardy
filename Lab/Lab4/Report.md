## 1. Настройка виртуального хоста основного сайта

![Создание директории проекта](screenshots/01-directory.png.png) — Создание `/var/www/boardy` и передача прав пользователю student

![Конфигурационный файл Nginx](screenshots/02-vhost-config.pn.png) — Конфиг `/etc/nginx/sites-available/boardy` с директивами server_name, root, access_log, error_log, error_page

## 2. Страницы проекта

![Главная страница Boardy](screenshots/03-landing.png.png) — Лендинг Boardy в браузере (домен виден в адресной строке)

![Форма обратной связи](screenshots/04-form.png.png) — Форма с полями "Имя" и "Сообщение", кнопка "Отправить"

![Кастомная страница 404](screenshots/05-404.png.png) — Страница 404 с подключенным CSS (URL несуществующей страницы виден)

## 3. Настройка поддомена API

![DNS-запись в VK Cloud](screenshots/06-dns-api.png.png) — A-запись для поддомена `api.pablo52.ai-info.ru` (IP, TTL видны)

![Проверка DNS через dig](screenshots/07-dig-api.png.png) — Вывод `dig +short api.pablo52.ai-info.ru` (IP сервера)

## 4. Исследование виртуальных хостов

![Запрос с Host: pablo52.ai-info.ru](screenshots/11.01-vhosts.png.png) — GET-запрос к основному домену (лендинг Boardy)

![Запрос с Host: api.pablo52.ai-info.ru](screenshots/11.02-vhosts.png.png) — GET-запрос к поддомену API (заглушка "Boardy API — Service: OK")

![Запрос с Host: unknown.ru](screenshots/11.03-vhosts.png.png) — Запрос с неизвестным Host (первый сайт по умолчанию)

## 5. HTTP-методы

![POST-запрос с ошибкой 405](screenshots/12-post-405.png.png) — Отправка формы методом POST (ответ 405 Method Not Allowed)

## 6. Логи сервера

![Просмотр логов](screenshots/13-logs.png.png) — Вывод `tail -5` для access-логов обоих сайтов

![Статистика логов](screenshots/14-log-stats.png.png) — Анализ логов с подсчетом запросов

---

**Вывод:** В ходе лабораторной работы были настроены два виртуальных хоста на одном сервере, исследованы HTTP-методы (GET, POST, HEAD), проанализированы логи и поведение сервера при разных заголовках Host.
