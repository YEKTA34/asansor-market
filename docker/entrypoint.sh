#!/bin/sh

# Cache configurations
echo "Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Start supervisord (which runs Nginx and PHP-FPM)
echo "Starting Supervisord..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf