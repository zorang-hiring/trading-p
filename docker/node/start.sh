#!/bin/bash

# install npm dependencies
cd /var/www/current
npm install

# build frontend
npm run dev
# npm run build

# keep container running
tail -f /dev/null