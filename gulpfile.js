// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');

var source_path = 'app/webroot/scss/**/*.scss',
    destin_path = 'app/webroot/css/';

// Z vs
gulp.task('default', function(cb) {
  gulp.src(
    //'app/webroot/scss/order/*.scss'
    source_path
    )
      .pipe(sass())
      .pipe(gulp.dest(
        //'app/webroot/css/order'
        destin_path
        ));
  cb();
});
