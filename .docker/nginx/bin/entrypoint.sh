#!/bin/bash
set -e

if [ -z "$1" ]; then
    exec nginx -g "daemon off;"
fi

exec "$@"

