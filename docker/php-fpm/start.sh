#!/bin/bash

# install composer dependencies
cd ../current
php composer.phar install
cd ../html

php-fpm