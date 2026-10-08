# Зависимости проекта (composer)

| № | Задача | Пакет |
| --- | --- | --- |
| 1 | БД | `doctrine/dbal` (+ `ext-pdo`) |
| 2 | Кеш в памяти для тяжёлых запросов | `symfony/cache` + `predis/predis` (Redis) |
| 3 | XLS-отчёты | `phpoffice/phpspreadsheet` |
| 4 | PDF-документы | `mpdf/mpdf` (нормально работает с кириллицей) |
| 5 | SMS-верификация | `twilio/sdk` |
| 6 | E-mail уведомления и рассылки | `symfony/mailer` |
| 7 | AWS S3 для статики | `league/flysystem-aws-s3-v3` (тянет `aws/aws-sdk-php`) |
| 8 | Расчёт доставки (Почта России) | `lapaygroup/russianpost` |
| 9 | Авторизация через соцсети | `hybridauth/hybridauth` (VK, Google, Яндекс и др.) |
| 10 | Выгрузка товаров в Яндекс.Маркет | `bukashk0zzz/yml-generator` (YML-фид, регулярность — через cron) |
| 11 | Онлайн-оплата | `yoomoney/yookassa-sdk-php` |
| 12 | Тестирование | `phpunit/phpunit` (require-dev) |

Необязательные расширения (`ext-redis`, `ext-apcu`) вынесены в `suggest`, PHPUnit — в `require-dev`, чтобы не попасть на прод.
`vendor/` в git не коммитится, `composer.lock` коммитится.

Установка: `composer install`, тесты: `composer test`.
