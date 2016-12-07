#!/bin/bash

BASEDIR=`dirname $0`
PROJECT_PATH=`cd $BASEDIR; pwd`
old_css_file=$PROJECT_PATH/web/css/bootstrap.css
new_css_file=$PROJECT_PATH/vendor/twbs/bootstrap/dist/css/bootstrap.css
old_js_file=$PROJECT_PATH/web/js/jquery.min.js
new_js_file=$PROJECT_PATH/vendor/components/jquery/jquery.min.js
rm $old_css_file $old_js_file
cp $new_css_file $PROJECT_PATH/web/css
cp $new_js_file $PROJECT_PATH/web/js

exit 0