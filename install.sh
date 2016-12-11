#!/bin/bash

composer update
mkdir -p web/css
cp -r vendor/twitter/bootstrap/dist/. web/bootstrap/
