#!/bin/sh

# Start devilbox in background
cd ~/devilbox
docker-compose up -d bind httpd php mysql
