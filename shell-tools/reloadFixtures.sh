#!/usr/bin/env bash

php ../app/console doc:data:drop --force
php ../app/console doc:data:create
php ../app/console doc:mi:mi --no-interaction
php ../app/console doc:schema:up --force
php ../app/console doc:fix:lo --no-interaction


