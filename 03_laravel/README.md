# Блог на Laravel + SQLite (Docker)

Версия приложения **v1.0.0** зафиксирована в `VERSION` и Git-теге.

PHP 8.4 (php-fpm) + nginx. На хост ничего ставить не нужно, только Docker.

Сайт доступен по адресу http://localhost:8050. Минимальные стили для Blade-страниц находятся в `public/css/app.css`.

Корень Laravel-приложения — `03_laravel/`. Команды Docker Compose выполняются из корня репозитория.

| Действие | Команда |
| --- | --- |
| Запустить | `docker compose up -d` |
| Остановить | `docker compose down` |
| artisan | `docker compose exec app php artisan ...` |
| composer | `docker compose exec app composer ...` |
| Запустить тесты | `docker compose exec app php artisan test` |

После `git clone` (без `vendor/` и `.env`):

```sh
docker compose up -d --build
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app touch database/database.sqlite
docker compose exec app php artisan migrate --seed
```

## Как показать работу с базой данных

- На `/posts` доступны список, просмотр, создание, редактирование и удаление записей. Фильтр использует `inCategory()`, а число записей рядом с категорией вычисляется через `HasMany`.
- На странице записи видны категория (`BelongsTo`) и теги (`BelongsToMany`). В форме комментария можно выбрать запись или её категорию (`MorphMany` и `MorphTo`).
- Удалённая запись попадает в `/posts/trash`, откуда её можно восстановить. `SoftDeletes` хранит дату удаления в `deleted_at`.
- `GET /api/posts` возвращает только опубликованные записи через `published()`. JSON формирует `PostResource`. При публикации без указанной даты используется текущее время.
- API поддерживает `GET` и `POST` на `/api/posts`, а также `GET`, `PUT`, `PATCH` и `DELETE` на `/api/posts/{id}`.

```sh
curl http://localhost:8050/api/posts
curl -X POST http://localhost:8050/api/posts -H 'Accept: application/json' \
  -d 'category_id=1&title=Hello&body=Text&is_published=1&published_at=2026-01-01&tags[]=1'
```
