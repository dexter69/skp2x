#!/bin/sh
cd ~/devilbox

# Stop devilbox
docker-compose stop

# Remove as in docs:
# https://devilbox.readthedocs.io/en/latest/getting-started/start-the-devilbox.html#background-1
docker-compose rm -f