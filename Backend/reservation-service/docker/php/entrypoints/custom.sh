#!/bin/sh

set -e

# If the .env file doesn't exist, copy .env.example to .env
if [ ! -f /home/php-app/application/.env ]; then
  su - php-app -c "cp /home/php-app/application/.env.example /home/php-app/application/.env"
fi

# Move the appropriate PHP ini file based on the VERSION_TYPE
if [ ! -f "$PHP_INI_DIR/php.ini" ]; then
  if [ "$VERSION_TYPE" = "development" ]; then
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
  else
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
  fi
fi

exec "$@"
