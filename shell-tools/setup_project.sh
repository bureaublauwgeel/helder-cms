#!/usr/bin/env bash

composer install
php app/console kuma:generate:bundle
php app/console bbg:generate:default-site
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction

bundle install
npm install --save bower gulp uglify-js uglifycss
npm shrinkwrap
node_modules/.bin/bower install
node_modules/.bin/bower build

php app/console assets:install --symlink
php app/console assetic:dump