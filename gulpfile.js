'use strict';
var gulp = require('gulp'),
    clean = require('gulp-clean'),
    less = require('less');


var
    src = 'web-src/';

gulp.task('fonts', function () {
    return gulp.src('bower_components/bootstrap/dist/fonts/*.*')
        .on('data', function (file) {
            console.log(file);
        })
        .pipe(gulp.dest(src + 'fonts'));
});

gulp.task('less', function () {
    return gulp.src('web/less/*.*')
        .on('data', function (file) {
            console.log(file);
        })
        .pipe(gulp.dest(src + 'less'));
});

gulp.task('clean', function () {
    del([
        web + '*'
    ]);
});
