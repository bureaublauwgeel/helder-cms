#!/usr/bin/env bash

SCRIPT_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

rm -rf ${SCRIPT_PATH}/../web/uploads &&
php ${SCRIPT_PATH}/../app/console doctrine:database:drop --force --if-exists &&
php ${SCRIPT_PATH}/../app/console doctrine:database:create &&
php ${SCRIPT_PATH}/../app/console doctrine:migrations:migrate --no-interaction --allow-no-migration &&
php ${SCRIPT_PATH}/../app/console doctrine:migrations:diff --no-interaction &&
php ${SCRIPT_PATH}/../app/console doctrine:migrations:migrate --no-interaction --allow-no-migration &&
php ${SCRIPT_PATH}/../app/console doctrine:fixtures:load --no-interaction &&
# php ${SCRIPT_PATH}/../app/console kuma:search:populate full &&
yarn install --cwd ${SCRIPT_PATH}/.. --non-interactive &&
bundle install --gemfile=${SCRIPT_PATH}/../Gemfile &&
php ${SCRIPT_PATH}/../app/console assetic:dump
# ${SCRIPT_PATH}/../node_modules/.bin/gulp build --cwd ${SCRIPT_PATH}/.. -LLLL
