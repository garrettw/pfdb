#!/bin/bash
# Elastic Beanstalk migration script with EB environment variable support

APP_DIR="/var/app/current"

# Ensure working directory is correct
cd "$APP_DIR" || { echo "[eb-migrate] ERROR: Failed to cd to $APP_DIR" >&2; exit 1; }

# Read EB environment properties using get-config utility
{
  echo "[$(date)] [eb-migrate] Starting migrate.sh in $APP_DIR"
  echo ""
} >&2

export DB_CONNECTION=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_CONNECTION 2>/dev/null || echo "sqlite")
export DB_HOST=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_HOST 2>/dev/null || echo "")
export DB_DATABASE=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_DATABASE 2>/dev/null || echo "")
export DB_USERNAME=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_USERNAME 2>/dev/null || echo "")
export DB_PASSWORD=$(/opt/elasticbeanstalk/bin/get-config environment -k DB_PASSWORD 2>/dev/null || echo "")

# Log the configuration and environment details
{
  echo "[eb-migrate] Diagnostics:"
  echo "[eb-migrate] DB_CONNECTION=$DB_CONNECTION"
  echo "[eb-migrate] DB_HOST=$DB_HOST"
  echo "[eb-migrate] DB_DATABASE=$DB_DATABASE"
  echo "[eb-migrate] DB_USERNAME=$DB_USERNAME"
  echo "[eb-migrate] APP_DIR=$APP_DIR"
  echo "[eb-migrate] PWD=$(pwd)"
  echo "[eb-migrate] USER=$(whoami)"
  echo "[eb-migrate] UID=$(id -u)"
  echo ""
} >&2

# Check if php artisan exists
if [ ! -f "$APP_DIR/artisan" ]; then
  echo "[eb-migrate] ERROR: artisan file not found at $APP_DIR/artisan" >&2
  exit 1
fi

# Skip migration if sqlite DB file doesn't exist
if [ "$DB_CONNECTION" = "sqlite" ] && [ ! -f "$APP_DIR/database/database.sqlite" ]; then
  echo "[eb-migrate] WARNING: sqlite DB file missing at $APP_DIR/database/database.sqlite; skipping migrate" >&2
  exit 0
fi

# Run migration with full error output
echo "[eb-migrate] Running: php artisan migrate --force" >&2
php artisan migrate --force 2>&1 | sed 's/^/[eb-migrate] /'
EXIT_CODE=$?

if [ $EXIT_CODE -eq 0 ]; then
  echo "[eb-migrate] SUCCESS: Migration completed" >&2
else
  echo "[eb-migrate] ERROR: Migration failed with exit code $EXIT_CODE" >&2
fi

exit $EXIT_CODE
