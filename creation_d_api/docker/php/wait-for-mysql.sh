#!/usr/bin/env bash

set -e

host="$1"

shift

port="$1"

shift

cmd="$@"

>&2 echo "Attempting to connect to $host at port $port"

until nc -z "$host" "$port"; do
    >&2 echo "MySQL is unavailable - sleeping"

    sleep 1
done

>&2 echo "MySQL is up - executing command"

exec $cmd