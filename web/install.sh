#!/bin/bash

cd ../var/cache

if [ -f "data.json" ]; then
        echo "File 'data.json' exists";
    else
	touch "data.json";
fi
