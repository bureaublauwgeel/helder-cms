#!/usr/bin/env bash

composer install
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction

bundle install
yarn install
node_modules/.bin/gulp build

php app/console assets:install --symlink
php app/console assetic:dump
