// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
const terser = require('gulp-terser');

var source_path = 'app/webroot/scss/**/*.scss',
    destin_path = 'app/webroot/css/';


// Z vs
gulp.task('default', function(cb) {
  gulp.src(source_path)
      .pipe(sass())
      .pipe(gulp.dest(destin_path));
  cb();
});

var s_path = 'app/webroot/webix/app/css/*.scss',
    d_path = 'app/webroot/webix/app/css/';

// Sass for webix
gulp.task('webixs', function(cb) {
  gulp.src(s_path)
      .pipe(sass())
      .pipe(gulp.dest(d_path));
  cb();
});

var
  jsFiles = [
    'app/webroot/webix/app/js/content/customers/listOfCustomers.js',
    'app/webroot/webix/app/js/content/orders/addNewQuickOrder.js',
    'app/webroot/webix/app/js/content/customers/customerDetail.js',
    'app/webroot/webix/app/js/content/customers/customerPanel.js',
    'app/webroot/webix/app/js/content/orders/privateOrders/conf.js',
    'app/webroot/webix/app/js/content/orders/privateOrders/eventsHandlers.js',
    'app/webroot/webix/app/js/content/orders/theOrderDetail/listOfCards.js',
    'app/webroot/webix/app/js/content/orders/theOrderDetail/theOrderDetail.js',
    'app/webroot/webix/app/js/content/orders/privateOrders/listOfPrivateOrders.js',
    'app/webroot/webix/app/js/content/orders/managePrivateOrders.js',                  
    'app/webroot/webix/app/js/content/customers/manageCustomers.js', 
    'app/webroot/webix/app/js/layout/toolbarMenu.js',
    'app/webroot/webix/app/js/layout/mainToolbar.js',
    'app/webroot/webix/app/js/layout/leftSidebar.js',
    'app/webroot/webix/app/js/layout/content.js',
    'app/webroot/webix/app/js/app.js'
  ],
  jsDest = 'app/webroot/webix/app/js';
  //'dist/scripts';

gulp.task('webixj', function() {
    return gulp.src(jsFiles)
        .pipe(concat('app.min.js'))
        .pipe(terser())
        .pipe(gulp.dest(jsDest));
});
