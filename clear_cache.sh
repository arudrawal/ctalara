#!/usr/bin/bash
php artisan cache:clear
php artisan route:cache
php artisan config:cach
#composer dump-autoload -o
