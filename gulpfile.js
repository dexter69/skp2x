// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');

var source_path = 'app/webroot/scss/**/*.scss',
    destin_path = 'app/webroot/css/';



gulp.task('sass', function() {
    gulp.src(source_path)
        .pipe(sass())
        .pipe(gulp.dest(destin_path))
});

// watch task
gulp.task('default', ['sass'], function() {
    gulp.watch(source_path, ['sass']);
})
