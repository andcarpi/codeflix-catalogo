#!/bin/bash

composer install
php artisan key:generate
php artisan key:generate --env=testing
php artisan migrate
php-fpm
