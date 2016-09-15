#!/usr/bin/env bash

CLIENT_NAME=$1
LOWER_CLIENT_NAME=`echo $1 | tr A-Z a-z`

composer install
php app/console kuma:generate:bundle --namespace=$CLIENT_NAME/WebsiteBundle --dir=/var/www/src --no-interaction
php app/console bbg:generate:default-site --namespace=$CLIENT_NAME/WebsiteBundle --prefix=${LOWER_CLIENT_NAME}_website_
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:migrations:diff
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