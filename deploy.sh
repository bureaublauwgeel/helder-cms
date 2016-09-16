#!/bin/bash

# make sure the script fails on error
set -e

# declare associative array with persistent source and desintation paths

declare -A PERSISTENT_PATH_MAPPING

PERSISTENT_PATH_MAPPING["uploads"]="web/uploads"

# check build number argument and pad it
RE_NUMBER='^[0-9]+$'
if ! [[ $1 =~ $RE_NUMBER ]] ; then
    echo "Argument provided is not a build number: $1"
    exit 1
fi

BUILD_NUMBER=`printf %04d $1`

# figure out relevant paths
BUILD_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_PATH="`dirname $BUILD_PATH`"
PERSISTENT_PATH="${ROOT_PATH}/persistent"
BUILDS_PATH="${ROOT_PATH}/builds"
DEST_PATH="${BUILDS_PATH}/build-${BUILD_NUMBER}"
WORK_PATH="${DEST_PATH}"
HTTP_PATH="${WORK_PATH}/web"

# move new build into place
mkdir -p $BUILDS_PATH

# Symfony2: create as symlink for the app/ folder for populating the search index via cron
rm -rf $BUILDS_PATH/current
ln -s $DEST_PATH $BUILDS_PATH/current

mv $BUILD_PATH $DEST_PATH

# Symfony2: install node modules with npm
npm install --prefix ${WORK_PATH}

# Symfony2: install ruby gems with bundler
bundle install --gemfile=${WORK_PATH}/Gemfile

# Symfony2: install the latest version of composer from the web
curl -sS https://getcomposer.org/installer | php -- --install-dir=${WORK_PATH}

# Symfony2: install vendor bundles and assets, optimize autoloader classmap
SYMFONY_ENV=prod php ${WORK_PATH}/composer.phar install --no-interaction --no-ansi --no-dev --optimize-autoloader --working-dir $WORK_PATH

# Bower install
${WORK_PATH}/node_modules/.bin/bower install --config.cwd=${WORK_PATH} --config.directory=app/Resources/vendor_bower/ --config.interactive=false



# fix file permissions
setfacl -Rn -m u:www-data:rwX -m u:deployment:rwX ${WORK_PATH}/app/cache ${WORK_PATH}/app/logs
setfacl -dRn -m u:www-data:rwX -m u:deployment:rwX ${WORK_PATH}/app/cache ${WORK_PATH}/app/logs

# Symfony2: update database schema by performing migrations (THIS MAY BE DANGEROUS)
php ${WORK_PATH}/app/console doctrine:migrations:migrate --no-interaction --env=prod

# Build with Gulp
${WORK_PATH}/node_modules/.bin/gulp build --cwd ${WORK_PATH} -LLLL

# Symfony2: clean and warm-up cache
php ${WORK_PATH}/app/console cache:clear --no-interaction --env=prod --no-debug

# Symfony2: dump production assets
BUNDLE_GEMFILE=${WORK_PATH}/Gemfile php ${WORK_PATH}/app/console assetic:dump --no-interaction --env=prod --no-debug

# symlink persistent dirs

for PERSISTENT_SRC in ${PERSISTENT_PATH}/*; do
    if [[ -d $PERSISTENT_SRC ]]; then
        PERSISTENT_SRC="`basename $PERSISTENT_SRC`"
    PERSISTENT_DST=${PERSISTENT_PATH_MAPPING[$PERSISTENT_SRC]}

    if ! [[ -z $PERSISTENT_DST ]]; then
            ln -s ${PERSISTENT_PATH}/${PERSISTENT_SRC} ${DEST_PATH}/${PERSISTENT_DST}
        fi
    fi
done

# Translations update
php ${WORK_PATH}/app/console kuma:translator:import --no-interaction --env=prod --no-debug

# Translations cache flush
php ${WORK_PATH}/app/console kuma:translator:cache --flush --no-interaction --env=prod --no-debug

# Symfony2: clean and warm-up cache again
php ${WORK_PATH}/app/console cache:clear --no-interaction --env=prod --no-debug

# remove deploy script itself
rm ${DEST_PATH}/"`basename "${BASH_SOURCE[0]}"`"

# symlink HTTP document root
ln -sfn $HTTP_PATH ${ROOT_PATH}/http

# clear PHP opcache and APC

curl -s -w "\n" http://localhost/clear_cache.php

# remove old versions, keep the last 3 builds
find ${BUILDS_PATH} -mindepth 1 -maxdepth 1 -type d | sort -rn | tail -n+4 | xargs -I % rm -rf "%"
