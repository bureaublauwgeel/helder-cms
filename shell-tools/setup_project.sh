#!/usr/bin/env bash

composer install
php app/console kuma:generate:bundle
php app/console bbg:generate:default-site
php app/console doctrine:database:create
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
php app/console doctrine:fixtures:load

npm install -g bower
npm install -g gulp
npm install --save uglify-js uglifycss
npm shrinkwrap

bundle install
npm install
bower install
gulp build

php app/console assets:install --symlink
php app/console assetic:dump