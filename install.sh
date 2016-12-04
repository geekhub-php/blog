#!/bin/bash

composer install
mkdir -p web/css
cp -r vendor/twitter/bootstrap/dist/. web/bootstrap/
