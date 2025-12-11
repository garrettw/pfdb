#!/bin/bash
# Elastic Beanstalk migration script with EB environment variable support

APP_DIR="/var/app/current"
LOG_FILE="/var/log/eb-migrate.log"

# Ensure working directory is correct
cd "$APP_DIR" || { echo "Failed to cd to $APP_DIR" > "$LOG_FILE"; exit 1; }

# Read EB environment properties using get-config utility
echo "[$(date)] Starting migrate.sh in $APP_DIR" > "$LOG_FILE"

export DB_CONNECTION=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_CONNECTION 2>/dev/null || echo "sqlite")
export DB_HOST=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_HOST 2>/dev/null || echo "")
export DB_DATABASE=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_DATABASE 2>/dev/null || echo "")
export DB_USERNAME=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_USERNAME 2>/dev/null || echo "")
export DB_PASSWORD=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_PASSWORD 2>/dev/null || echo "")

# Log the configuration (mask password)
{
  echo "[eb-migrate] DB_CONNECTION=$DB_CONNECTION"
  echo "[eb-migrate] DB_HOST=$DB_HOST"
  echo "[eb-migrate] DB_DATABASE=$DB_DATABASE"
  echo "[eb-migrate] DB_USERNAME=$DB_USERNAME"
  echo "[eb-migrate] APP_DIR=$APP_DIR"
  echo "[eb-migrate] PWD=$(pwd)"
  echo "[eb-migrate] PATH=$PATH"
} >> "$LOG_FILE"

# Check if php artisan exists
if [ ! -f "$APP_DIR/artisan" ]; then
  echo "[eb-migrate] ERROR: artisan file not found at $APP_DIR/artisan" >> "$LOG_FILE"
  exit 1
fi

# Skip migration if sqlite DB file doesn't exist
if [ "$DB_CONNECTION" = "sqlite" ] && [ ! -f "$APP_DIR/database/database.sqlite" ]; then
  echo "[eb-migrate] WARNING: sqlite DB file missing at $APP_DIR/database/database.sqlite; skipping migrate" >> "$LOG_FILE"
  exit 0
fi

# Run migration with full error output (don't use set -e so we can capture the exit code)
echo "[eb-migrate] Running: php artisan migrate --force" >> "$LOG_FILE"
php artisan migrate --force >> "$LOG_FILE" 2>&1
EXIT_CODE=$?

if [ $EXIT_CODE -eq 0 ]; then
  echo "[eb-migrate] SUCCESS: Migration completed" >> "$LOG_FILE"
  exit 0
else
  echo "[eb-migrate] ERROR: Migration failed with exit code $EXIT_CODE" >> "$LOG_FILE"
  exit $EXIT_CODE
fi

