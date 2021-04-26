#!/bin/bash

DIR="$( cd "$(dirname "$0")" ; pwd -P )"
PLUGIN_NAME="ml"
OTHER=$*


run_bash() {
  docker run --rm -it \
    -v $DIR:/var/www/html \
    -v $DIR:/var/www/${PLUGIN_NAME} \
    --name phpunit hillliu/pmvc-phpunit \
    bash 
}

test() {
  docker run --rm \
    -v $DIR:/var/www/html \
    -v $DIR:/var/www/${PLUGIN_NAME} \
    --name phpunit hillliu/pmvc-phpunit \
    phpunit $OTHER 
}

case "$1" in
  bash)
    run_bash
    ;;

  *)
    test
    ;;
esac

exit $?

# docker-compose run --rm phpunit phpunit --no-configuration --bootstrap ./include_test.php ./tests-legacy/test.php
