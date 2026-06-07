#!/bin/sh

# If using SQLite and database file doesn't exist, create it and run migrations with seed
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    export DB_CONNECTION="sqlite"
    if [ -z "$DB_DATABASE" ]; then
        export DB_DATABASE="/var/www/html/database/database.sqlite"
    fi
    
    if [ ! -f "$DB_DATABASE" ]; then
        echo "Creating SQLite database file at $DB_DATABASE..."
        mkdir -p "$(dirname "$DB_DATABASE")"
        touch "$DB_DATABASE"
        echo "Running database migrations and seeding..."
        php artisan migrate --force --seed
    else
        echo "Running database migrations..."
        php artisan migrate --force
    fi
else
    echo "Running database migrations..."
    php artisan migrate --force
fi

# Cache configurations
echo "Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisord (which runs Nginx and PHP-FPM)
echo "Starting Supervisord..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf