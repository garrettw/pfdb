#!/bin/bash
# Elastic Beanstalk migration script with EB environment variable support

# Read EB environment properties using get-config utility and export variables for Laravel
export DB_CONNECTION=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_CONNECTION 2>/dev/null || echo "sqlite")
export DB_HOST=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_HOST 2>/dev/null)
export DB_DATABASE=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_DATABASE 2>/dev/null)
export DB_USERNAME=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_USERNAME 2>/dev/null)
export DB_PASSWORD=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_PASSWORD 2>/dev/null)

# Log the configuration
echo "[eb-migrate] DB_CONNECTION=$DB_CONNECTION DB_DATABASE=$DB_DATABASE" > /var/log/eb-migrate.log

# Skip migration if sqlite DB file doesn't exist
if [ "$DB_CONNECTION" = "sqlite" ] && [ ! -f database/database.sqlite ]; then
  echo "[eb-migrate] sqlite DB file missing; skipping migrate" >> /var/log/eb-migrate.log
  exit 0
fi

# Run migration
php artisan migrate --force >> /var/log/eb-migrate.log 2>&1
