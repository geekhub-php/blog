#!/bin/bash

file = 'data.json'

cd ../var/cache

if [ -f $file ]; then
	echo "File exists"
#touch data.json