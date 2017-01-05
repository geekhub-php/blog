'use strict';

var gulp = require('gulp'),
    watch = require('gulp-watch'),
    prefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    cssmin = require('gulp-clean-css'),
    imagemin = require('gulp-imagemin');

gulp.task('init-css', function() {
    return gulp.src([
            'bower_components/bootstrap/dist/css/bootstrap.min.css',
            'bower_components/bootstrap/dist/css/bootstrap-theme.min.css'
        ])
        .pipe(gulp.dest('web/public/css'))
});

gulp.task('init-fonts', function() {
    return gulp.src('bower_components/bootstrap/dist/fonts/*.*')
        .pipe(gulp.dest('web/public/fonts'))
});

gulp.task('init-js', function() {
    return gulp.src([
            'bower_components/bootstrap/dist/js/bootstrap.min.js',
            'bower_components/jquery/dist/jquery.min.js'
        ])
        .pipe(gulp.dest('web/public/js'))
});

gulp.task('init-libs', function() {
    var tasks = [
        'init-css',
        'init-fonts',
        'init-js'
    ];

    tasks.forEach(function (val) {
        gulp.start(val);
    });
});

gulp.task('minimize-css', function() {
    return gulp.src(['web-src/public/css/styles.css', 'web-src/public/css/modals.css'])
        .pipe(prefixer())
        .pipe(cssmin())
        .pipe(gulp.dest('web/public/css'))
});

gulp.task('minimize-js', function() {
    return gulp.src('web-src/public/js/functions.js')
        .pipe(uglify())
        .pipe(gulp.dest('web/public/js'))
});

gulp.task('watch', ['minimize-css', 'minimize-js'], function() {
    gulp.watch('web-src/public/css/*.css', ['minimize-css']);
    gulp.watch('web-src/public/js/*.js', ['minimize-js']);
});
