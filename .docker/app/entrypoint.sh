#!/bin/bash

php artisan optimize:clear
php artisan optimize
php artisan view:cache
