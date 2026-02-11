#!/bin/bash

# Wait a moment for deployment to fully complete
sleep 2

# Change to application directory
cd /var/app/current

# Create directories if they don't exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Fix ownership and permissions
chown -R webapp:webapp storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Rotate deployment log
mv storage/logs/laravel.log storage/logs/laravel.staging.log

# Ensure log files are writable
touch storage/logs/laravel.log
chown webapp:webapp storage/logs/laravel.log
chmod 664 storage/logs/laravel.log

echo "Laravel permissions fixed"
