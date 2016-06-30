#!/usr/bin/env bash

php ../app/console doc:data:drop --force
php ../app/console doc:data:create
php ../app/console doc:mi:mi
php ../app/console doc:mi:di
php ../app/console doc:mi:mi
php ../app/console doc:fix:lo


