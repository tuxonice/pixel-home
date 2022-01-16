#!/bin/sh

set -e

XDEBUG_INI_FILE="/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
DISABLED_EXT="disabled"

if [ -f "${XDEBUG_INI_FILE}.${DISABLED_EXT}" ]; then
    mv "${XDEBUG_INI_FILE}.${DISABLED_EXT}" "${XDEBUG_INI_FILE}"
fi

if [ ! -f "${XDEBUG_INI_FILE}" ]; then
    docker-php-ext-enable xdebug
    sed -i '1 a xdebug.mode=debug' "${XDEBUG_INI_FILE}"
    sed -i '1 a xdebug.client_host=host.docker.internal' "${XDEBUG_INI_FILE}"
    sed -i '1 a xdebug.max_nesting_level=400' "${XDEBUG_INI_FILE}"
fi
