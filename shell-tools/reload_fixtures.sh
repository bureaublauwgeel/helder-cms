#!/usr/bin/env bash

SCRIPT_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

rm -rf ${SCRIPT_PATH}/../web/uploads &&
php ${SCRIPT_PATH}/../bin/console doctrine:database:drop --force --if-exists &&
php ${SCRIPT_PATH}/../bin/console doctrine:database:create &&
php ${SCRIPT_PATH}/../bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration &&
php ${SCRIPT_PATH}/../bin/console doctrine:schema:update --force &&
php ${SCRIPT_PATH}/../bin/console doctrine:fixtures:load --no-interaction
# php ${SCRIPT_PATH}/../bin/console kuma:search:populate full
