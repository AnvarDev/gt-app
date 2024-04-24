#!/bin/bash

environment=${APP_ENV:-production}

printf "<<<<< Versions >>>>>\n"

php -v

printf "NODE "
node -v

printf "NPM "
npm -v

printf "<<<<< Permissions & Install dependencies & Compiling >>>>>\n"

chmod -R ug+rw storage bootstrap/cache

# Install composer dependencies
composer install \
    --quiet \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# npm install & run compiling
npm install --no-save && npm run build

if [ "$environment" = "local" ]; then
    # Wait for other docker images to be started
    /wait
fi

printf "<<<<< Set up & clearing >>>>>\n"

# Clear route cache
php artisan route:clear

# Clear configuration cache
php artisan config:clear

# Clear the compiled classes and services application cache
php artisan clear-compiled

printf "<<<<< Migration >>>>>\n"

#Running migrations
php artisan migrate --force

#Running important seeders
php artisan db:seed --force

printf "**************************************************\n"

printf "\033[42m\033[1;37mApplication starts with the environment: ${environment}\033[0m\n"

printf "**************************************************\n"

# Running php-fpm command
php-fpm
