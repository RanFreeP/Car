## php version 8.0

## Install

- composer install
- php artisan migrate
- php artisan db:seed --class=UserSeeder

## Запуск тестов
Для запуска тестов необходимо авторизоваться под логином "Admin" и паролем "123456"
Далее полученный токен ввести в ENV файле в ADMIN_TOKEN и запустить тесты
- php artisan test

## Документация
Документация по адресу http://domain.loc/api/documentation#/
