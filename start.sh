#!/usr/bin/env bash
php artisan migrate && php artisan passport:install && php artisan serve --host 0.0.0.0
exec "$@"
