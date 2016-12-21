var gulp         = require('gulp'),
    del          = require('del');

gulp.task('js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js'
    ])
        .pipe(gulp.dest('web/js'));
});

gulp.task('css', function() {
    return gulp.src([
        'bower_components/bootstrap/dist/css/*',
        'web-src/base-template.css'
    ])
        .pipe(gulp.dest('web/css/'));
});

gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/fonts/'))
});

gulp.task('clean', function () {
    del(['js', 'fonts', 'css']);
});

gulp.task('default', function () {
    var tasks = [
        'clean',
        'fonts',
        'css',
        'js'
    ];

    tasks.forEach(function (val) {
        gulp.start(val);
    });
});

