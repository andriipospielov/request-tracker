#!/usr/bin/env bash

/usr/local/bin/composer install --no-interaction --dev --no-scripts --prefer-dist --optimize-autoloader

/code/bin/console doctrine:migrations:migrate -n

php-fpm
