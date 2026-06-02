#!/bin/sh
set -e

php artisan storage:link || true
php artisan migrate --force

exec apache2-foreground
