// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');

var source_path = 'app/webroot/scss/**/*.scss',
    destin_path = 'app/webroot/css/';

var s_path = 'app/webroot/webix/app/css/*.scss',
    d_path = 'app/webroot/webix/app/css/';

// Z vs
gulp.task('default', function(cb) {
  gulp.src(source_path)
      .pipe(sass())
      .pipe(gulp.dest(destin_path));
  cb();
});

// Sass for webix
gulp.task('webixs', function(cb) {
  gulp.src(s_path)
      .pipe(sass())
      .pipe(gulp.dest(d_path));
  cb();
});
