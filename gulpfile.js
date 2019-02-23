// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');

var source_path = 'app/webroot/scss/**/*.scss',
    destin_path = 'app/webroot/css/';

// Z vs
gulp.task('default', function(cb) {
  gulp.src(source_path)
      .pipe(sass())
      .pipe(gulp.dest(destin_path));
  cb();
});
