#!/bin/sh
set -e

# Ensure storage and bootstrap/cache are writable by the runtime user
# (bind-mounted volumes from Windows can reset ownership on host writes).
if [ -d /var/www/html/storage ]; then
    chown -R www-data:www-data /var/www/html/storage
    chmod -R 775 /var/www/html/storage
fi

if [ -d /var/www/html/bootstrap/cache ]; then
    chown -R www-data:www-data /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/bootstrap/cache
fi

# Make sure the log file exists with correct perms.
touch /var/www/html/storage/logs/laravel.log
chown www-data:www-data /var/www/html/storage/logs/laravel.log
chmod 664 /var/www/html/storage/logs/laravel.log

# Hand off to the original command (php-fpm).
exec "$@"
