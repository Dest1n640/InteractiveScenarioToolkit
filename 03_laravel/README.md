# Laravel в Docker

PHP 8.4 (php-fpm) + nginx. На хост ничего ставить не нужно, только Docker.

Сайт: http://localhost:8050

`Dockerfile`, `compose.yaml` и `nginx/` лежат в корне репозитория, все команды ниже выполняются оттуда.

| Действие | Команда |
| --- | --- |
| Запустить | `docker compose up -d` |
| Остановить | `docker compose down` |
| artisan | `docker compose exec app php artisan ...` |
| composer | `docker compose exec app composer ...` |
| php | `docker compose exec app php ...` |
| Пересобрать образ | `docker compose up -d --build` |

После `git clone` (без `vendor/` и `.env`):

```sh
docker compose up -d --build
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app touch database/database.sqlite
docker compose exec app php artisan migrate
```
