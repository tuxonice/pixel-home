#!/usr/bin/env bash

if [ "$1" == "enable" ]; then
    docker-compose exec app sh -c "/enable-xdebug.sh && service apache2 reload"
elif [ "$1" == "disable" ]; then
    docker-compose exec app sh -c "/disable-xdebug.sh && service apache2 reload"
else
    echo "Unknown xdebug command $1"
fi
