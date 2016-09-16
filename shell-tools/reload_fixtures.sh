#!/usr/bin/env bash

php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction




