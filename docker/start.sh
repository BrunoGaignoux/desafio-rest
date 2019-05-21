#!/usr/bin/env sh

_="$(dirname "$0")/_functions"

if [ "$ENVIRONMENT" = "local" ]; then
    $_/user_setup www-data
    $_/composer
else
    $_/permissions_set
fi

$_/database_migrate

echo "===> Running supervisor"

/usr/bin/supervisord