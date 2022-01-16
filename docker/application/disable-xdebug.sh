#!/bin/sh

set -e

XDEBUG_INI_FILE="/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
DISABLED_EXT="disabled"

if [ -f "${XDEBUG_INI_FILE}" ]; then
    mv "${XDEBUG_INI_FILE}" "${XDEBUG_INI_FILE}.${DISABLED_EXT}"
fi
