#!/usr/bin/env bash

composer install
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction

bundle install
npm install --save bower gulp uglify-js uglifycss
npm install
npm shrinkwrap
node_modules/.bin/bower install --config.interactive=false
node_modules/.bin/gulp build

php app/console assets:install --symlink
php app/console assetic:dump