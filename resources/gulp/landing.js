var gulp = require('gulp');
var uglify = require('gulp-uglify');
var cssmin = require('gulp-cssmin');
var stylus = require('gulp-stylus');
var less = require('gulp-less');
var concat = require('gulp-concat');
var replace = require('gulp-replace');

//front-end
var landPaths = {
    js: [
        //jquery
        'bower_components/jquery/dist/jquery.js',
        'bower_components/d3/d3.min.js',

        //semantic
        'bower_components/semantic/dist/components/visibility.js',
		'bower_components/semantic/dist/components/sidebar.js',
		'bower_components/semantic/dist/components/dimmer.js',
		'bower_components/semantic/dist/components/modal.js',
		'bower_components/semantic/dist/components/tab.js',
		'bower_components/semantic/dist/components/transition.js',

        //angular
        'bower_components/angular/angular.min.js',
        'bower_components/angular-route/angular-route.min.js',
        'bower_components/angular-sanitize/angular-sanitize.min.js',
        'bower_components/angular-superswipe/superswipe.js',
        'bower_components/angular-touch/angular-touch.min.js',
        'bower_components/angular-resource/angular-resource.min.js',
        'bower_components/angular-ui-router/release/angular-ui-router.min.js',
        'bower_components/angulartics/dist/angulartics.min.js',
        'bower_components/angulartics-google-analytics/dist/angulartics-ga.min.js',

        'bower_components/satellizer/satellizer.min.js',

		'resources/js/kg.landing.js',
	],
    less: [
		'resources/assets/uikit.less',
	],
	css: [

        //semantic-ui
        'bower_components/semantic/dist/components/reset.css',
		'bower_components/semantic/dist/components/site.css',

		'bower_components/semantic/dist/components/container.css',
		'bower_components/semantic/dist/components/dimmer.css',
		'bower_components/semantic/dist/components/grid.css',
		'bower_components/semantic/dist/components/header.css',
		'bower_components/semantic/dist/components/image.css',
		'bower_components/semantic/dist/components/input.css',
		'bower_components/semantic/dist/components/form.css',
		'bower_components/semantic/dist/components/menu.css',
		'bower_components/semantic/dist/components/modal.css',

		'bower_components/semantic/dist/components/divider.css',
		'bower_components/semantic/dist/components/dropdown.css',
		'bower_components/semantic/dist/components/segment.css',
		'bower_components/semantic/dist/components/button.css',
		'bower_components/semantic/dist/components/list.css',
		'bower_components/semantic/dist/components/icon.css',
		'bower_components/semantic/dist/components/sidebar.css',
		'bower_components/semantic/dist/components/statistic.css',
		'bower_components/semantic/dist/components/tab.css',
		'bower_components/semantic/dist/components/transition.css',

        //uikit
		/*'resources/css/uikit.css',
		'bower_components/uikit/css/components/sticky.min.css',
        'bower_components/uikit/css/components/notify.almost-flat.min.css',*/

        'public/fonts/Asap-Regular.css',
        'public/fonts/Panefresco500wtRegular.css',
        'public/fonts/icons.css',
        'resources/css/katalogram-icon.css',

        'resources/css/katalogram.styl',
        'resources/css/kg.landing.css'
    ]
};

gulp.task('landing-jsmin', function() {
  return gulp.src(landPaths.js)
    .pipe(uglify())
    .pipe(concat('kg.landing.min.js'))
    .pipe(gulp.dest('public/js'));
});

/*
gulp.task('less', function () {
  return gulp.src(paths.less)
    .pipe(less())
	.pipe(concat('uikit.css'))
    .pipe(gulp.dest('resources/css'));
});*/

gulp.task('landing-cssmin', function () {
    return gulp.src(landPaths.css)
        .pipe(stylus())
        .pipe(cssmin({processImport: false}))
        .pipe(concat('kg.landing.min.css'))
        .pipe(gulp.dest('public/css'));
});

gulp.task('landing-watch', function() {
  gulp.watch(landPaths.js, ['jsmin']);
  gulp.watch(landPaths.css, ['cssmin']);
});

gulp.task('default', ['landing-watch', 'landing-jsmin', 'landing-cssmin']);
