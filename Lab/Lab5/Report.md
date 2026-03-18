## Часть A. HTTPS для основного сайта

### Задание 1. Установка certbot
![01-certbot-installed.png](screenshots/01-certbot-installed.png.png)  
*Скриншот: вывод certbot --version*

### Задание 2. Получение сертификата
![02-certbot-success.png](screenshots/02-certbot-success.png.png)  
*Скриншот: Successfully received certificate*

### Задание 3. Проверка в браузере
![03-browser-lock.png](screenshots/03-browser-lock.png.png)  
*Скриншот: браузер с замочком (домен виден в адресной строке)*

![04-certificate-info.png](screenshots/04-certificate-info.png.png)  
*Скриншот: информация о сертификате (кому, кто выдал, срок)*

### Задание 4. Редирект
![05-redirect.png](screenshots/05-redirect.png.png)  
*Скриншот: вывод curl -v с 301*

**В отчёте:** В выводе виден код **301 Moved Permanently** и заголовок **Location: https://pablo52.ai-info.ru/**.

### Задание 5. Конфиг после certbot
![06-nginx-ssl-config.png](screenshots/06-nginx-ssl-config.png.png)  
*Скриншот: конфиг с подписями*

**В отчёте:** Certbot добавил строки:  
- **listen 443 ssl;**  
- **ssl_certificate /etc/letsencrypt/live/pablo52.ai-info.ru/fullchain.pem;**  
- **ssl_certificate_key /etc/letsencrypt/live/pablo52.ai-info.ru/privkey.pem;**

---

## Часть B. HTTPS для API-сервиса

### Задание 6. Сертификат для api-поддомена
![07-api-certbot.png](screenshots/07-api-certbot.png.png)  
*Скриншот: успешное получение*

### Задание 7. Проверка обоих доменов
![08-both-https.png](screenshots/08-both-https.png.png)  
*Скриншот: оба ответа 200 с заголовками (два запроса в одном скриншоте)*

---

## Часть C. Разбор TLS

### Задание 8. TLS handshake
![09-tls-handshake.png](screenshots/09-tls-handshake.png.png)  
*Скриншот: вывод с подписями*

**В отчёте:**  
- **Версия TLS:** TLSv1.3  
- **Алгоритм шифрования:** TLS_AES_256_GCM_SHA384  
- **Subject:** CN = pablo52.ai-info.ru  
- **Issuer:** C = US, O = Let's Encrypt, CN = R3  
- **Срок действия:** Not Before: ... Not After: ...

### Задание 9. Цепочка доверия
![10-chain.png](screenshots/10-chain.png.png)  
*Скриншот: вывод openssl*

**В отчёте:**  
**Цепочка доверия:**  
Корневой CA (ISRG Root X1) → Промежуточный CA (R3) → Сертификат сайта (pablo52.ai-info.ru)

**Как браузер проверяет цепочку:**  
Браузер получает сертификат сайта и промежуточный сертификат, проверяет подписи по цепочке до корневого сертификата, который находится в доверенном хранилище браузера.

### Задание 10. Сравнение сертификатов
![11-compare-certs.png](screenshots/11-compare-certs.png.png)  
*Скриншот: вывод для обоих доменов*

**В отчёте:**  
**Общее:** Оба сертификата выданы Let's Encrypt (R3), одинаковый срок действия.  
**Отличия:** Разные Common Name (CN): pablo52.ai-info.ru и api.pablo52.ai-info.ru.

---

## Часть D. HSTS, кэширование, gzip

### Задание 11. HSTS
![12-hsts.png](screenshots/12-hsts.png.png)  
*Скриншот: заголовок Strict-Transport-Security в ответе*

**В отчёте:**  
**HSTS (HTTP Strict Transport Security)** — это механизм, который заставляет браузер всегда использовать HTTPS при подключении к сайту. Защищает от downgrade-атак и перехвата cookie в открытом виде.

### Задание 12. Кэширование и gzip
![13-cache-gzip.png](screenshots/13-cache-gzip.png.png)  
*Скриншот: оба заголовка (Cache-Control и Content-Encoding: gzip)*

### Задание 13. Автообновление
![14-renew.png](screenshots/14-renew.png.png)  
*Скриншот: Congratulations, all simulated renewals succeeded*

---
