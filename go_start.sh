#!/bin/bash
echo "my script Installing Composer"
COMPOSER_CMD=$(which composer)
$COMPOSER_CMD instal
php bin/console cache:warmup
# $COMPOSER_CMD update
