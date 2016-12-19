var gulp = require('gulp');
    del = require('del'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins();


gulp.task('less', function () {
   return gulp.src('web-src/less/app.less')
       .pipe(plugins.sourcemaps.init())
       .pipe(plugins.less())
       .pipe(plugins.cssmin())
       .pipe(plugins.sourcemaps.write())
       .pipe(gulp.dest('web/css'))
});

gulp.task('js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js'
    ])
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.concat('app.js'))
        .pipe(plugins.uglify())
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest('web/js'));
});

gulp.task('images', function () {
    return gulp.src(['web-src/images/**/*'])
        .pipe(gulp.dest('web/images/'))
});

gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/fonts/'))
    });

gulp.task('clean', function () {
        del(['less', 'js', 'images', 'fonts']);
});

gulp.task('build', ['less', 'js', 'images', 'fonts']);

gulp.task('watch', ['less', 'js', 'images', 'fonts'], function () {
    gulp.watch('web-src/less/*', ['less']);
    gulp.watch('web-src/js/*.js', ['js']);
    gulp.watch('web-src/images/*', ['images']);
    gulp.watch('web-src/fonts/*', ['fonts']);
});

gulp.task('default', ['clean', 'build', 'watch']);














