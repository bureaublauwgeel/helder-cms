#!/usr/bin/env bash

# Database poof gone
php app/console doctrine:database:drop --force &&
# Create poofed database
php app/console doctrine:database:create &&
# Migrate all available migrations
php app/console doctrine:migrations:migrate --no-interaction &&
# So you don't need a migration in you feature branch
php app/console doc:schema:up --force &&
# And what we are all waiting for.
php app/console doctrine:fixtures:load --no-interaction
# With search add this
# && php app/console kuma:search:populate full
