#!/bin/bash

# Change to application directory
cd /var/app/current

php artisan optimize

# Fix ownership and permissions in case they changed
chown -R webapp:webapp storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown webapp:webapp storage/logs/laravel.log
chmod 664 storage/logs/laravel.log
