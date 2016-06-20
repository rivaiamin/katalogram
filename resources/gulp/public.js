var gulp = require('gulp');
var uglify = require('gulp-uglify');
var include = require('gulp-include');
var imagemin = require('gulp-imagemin');
var cssmin = require('gulp-cssmin');
var stylus = require('gulp-stylus');
var less = require('gulp-less');
var htmlmin = require('gulp-htmlmin');
var jsonmin = require('gulp-jsonmin');
var fontmin = require('fontmin');
var concat = require('gulp-concat');
var replace = require('gulp-replace');

//front-end
var paths = {
    images: [
        'resources/img/*',
        'resources/img/**/*'
    ],
    fonts: [
        'resources/fonts/*',
        'bower_components/semantic/dist/themes/default/assets/fonts/*'
    ],
    libjs: [
        //jquery
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/d3/d3.min.js',
        //'bower_components/jquery-knob/dist/jquery.knob.min.js',
        /*'bower_components/jquery-embedly/jquery.embedly.min.js',*/

        //semantic
        'bower_components/semantic/dist/components/accordion.min.js',
        'bower_components/semantic/dist/components/checkbox.min.js',
        'bower_components/semantic/dist/components/dimmer.min.js',
        'bower_components/semantic/dist/components/dropdown.min.js',
        'bower_components/semantic/dist/components/popup.min.js',
        'bower_components/semantic/dist/components/tab.min.js',
        'bower_components/semantic/dist/components/transition.min.js',
        //'bower_components/semantic/dist/components/sidebar.min.js',

        //uikit
        //'bower_components/uikit/js/uikit.min.js',
        'bower_components/uikit/js/core/core.min.js',
        'bower_components/uikit/js/core/modal.min.js',
        'bower_components/uikit/js/core/nav.min.js',
        'bower_components/uikit/js/core/offcanvas.min.js',
        'bower_components/uikit/js/components/grid.min.js',
        'bower_components/uikit/js/components/slider.min.js',
        //'bower_components/uikit/js/components/upload.min.js',
        'bower_components/uikit/js/components/notify.min.js',
        'bower_components/uikit/js/components/sticky.min.js',
        //'bower_components/uikit/js/components/htmleditor.min.js',

        //htmleditor
        /*'bower_components/codemirror/lib/codemirror.js',
        'bower_components/codemirror/addon/mode/overlay.js',
        'bower_components/codemirror/mode/markdown/markdown.js',
        'bower_components/codemirror/mode/gfm/gfm.js',
        'bower_components/codemirror/mode/xml/xml.js',
        'bower_components/marked/marked.min.js',*/

        //angular
        'bower_components/angular/angular.min.js',
        'bower_components/angular-route/angular-route.min.js',
        'bower_components/angular-sanitize/angular-sanitize.min.js',
        'bower_components/angular-superswipe/superswipe.js',
        'bower_components/angular-touch/angular-touch.min.js',
        'bower_components/angular-resource/angular-resource.min.js',
        'bower_components/angular-ui-router/release/angular-ui-router.min.js',
        'bower_components/angular-input-stars-directive/angular-input-stars.js',
        'bower_components/ng-file-upload/ng-file-upload.min.js',

		//'bower_components/cropme/cropme.js',
        /*'bower_components/angular-ui-grid/ui-grid.min.js',*/
        'bower_components/satellizer/satellizer.min.js',
        'bower_components/ng-tags-input/ng-tags-input.min.js',
        'bower_components/ng-knob/dist/ng-knob.min.js',
        'bower_components/angular-validation-match/dist/angular-validation-match.min.js',
        //'bower_components/angular-knob/resources/angular-knob.js',
        //'bower_components/ng-img-crop/compile/minified/ng-img-crop.js',
        'bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js',
		'bower_components/angular-environment/dist/angular-environment.min.js',

        //'bower_components/holderjs/holder.min.js'
    ],
	js:[
		'resources/js/client/kg.*.js',
		'resources/js/client/app.js',
	],
    less: [
		'resources/assets/uikit.less',
	],
	css: [

        //semantic-ui
        //'bower_components/semantic/dist/semantic.min.css',
        'bower_components/semantic/dist/components/accordion.min.css',
        'bower_components/semantic/dist/components/button.min.css',
        'bower_components/semantic/dist/components/card.min.css',
        'bower_components/semantic/dist/components/checkbox.min.css',
        'bower_components/semantic/dist/components/comment.min.css',
        'bower_components/semantic/dist/components/container.min.css',
        'bower_components/semantic/dist/components/divider.min.css',
        'bower_components/semantic/dist/components/dropdown.min.css',
        'bower_components/semantic/dist/components/form.min.css',
        'bower_components/semantic/dist/components/header.min.css',
        'bower_components/semantic/dist/components/image.min.css',
        'bower_components/semantic/dist/components/list.min.css',
        'bower_components/semantic/dist/components/icon.min.css',
        'bower_components/semantic/dist/components/input.min.css',
        'bower_components/semantic/dist/components/label.min.css',
        'bower_components/semantic/dist/components/dimmer.min.css',
        'bower_components/semantic/dist/components/menu.min.css',
        'bower_components/semantic/dist/components/message.min.css',
        'bower_components/semantic/dist/components/popup.min.css',
        'bower_components/semantic/dist/components/reset.min.css',
        'bower_components/semantic/dist/components/segment.min.css',
        'bower_components/semantic/dist/components/site.min.css',
        'bower_components/semantic/dist/components/tab.min.css',
        'bower_components/semantic/dist/components/transition.min.css',

        //uikit
		'resources/css/uikit.css',
		'bower_components/uikit/css/components/sticky.min.css',
        'bower_components/uikit/css/components/notify.almost-flat.min.css',
        /*'bower_components/uikit/css/uikit.almost-flat.min.css',
        'bower_components/uikit/css/components/slider.min.css',
        'bower_components/uikit/css/components/slidenav.min.css',
        'bower_components/uikit/css/components/form-file.min.css',
        'bower_components/uikit/css/components/upload.min.css',
        'bower_components/uikit/css/components/progress.min.css',
        'bower_components/uikit/css/components/htmleditor.min.css',
        'bower_components/uikit/css/components/notify.almost-flat.min.css',*/

        //angular
        'bower_components/angular-input-stars-directive/angular-input-stars.css',
        'bower_components/cropme/cropme.css',
        /*'bower_components/angular-ui-grid/ui-grid.min.css',*/
        /*'bower_components/codemirror/lib/codemirror.css',*/
        'bower_components/ng-tags-input/ng-tags-input.min.css',
        'bower_components/ng-tags-input/ng-tags-input.bootstrap.min.css',
        //'bower_components/ng-img-crop/compile/minified/ng-img-crop.css',

        //'public/fonts/Glametrix.css',
        /*'public/fonts/DHF Broffont Script.css',*/
        //'public/fonts/CaviarDreams.css',
        'public/fonts/Asap-Regular.css',
        'public/fonts/Panefresco500wtRegular.css',
        'public/fonts/icons.css',
        'resources/css/katalogram-icon.css',

        'resources/css/katalogram.styl'
    ],
    html: [
        'resources/views/**/*.html',
    ],
    htmlpublic: [
        'public/*.html',
        'public/views/**/*.html',
    ],
    json: [
        'resources/json/*.json'
    ],
    exportjs: [
        'bower_components/angular/angular.min.js',
        'bower_components/d3/d3.min.js',
        'bower_components/angular-input-stars-directive/angular-input-stars.js',
        'bower_components/ng-knob/dist/ng-knob.min.js',
        'resources/js/export.js'
    ]
};

/*elixir(function(mix) {

    // admin less
    mix.less('admin.less', 'public/css/admin/');

    mix.styles([
        'admin/bootstrap.min.css',
        'admin/app.css',
        'admin/jquery-jvectormap-1.2.2.css'
    ], 'public/css/admin-css.css', 'public/css');

    mix.scripts([
        'admin/jQuery/jQuery-2.1.4.min.js',
        'admin/bootstrap.min.js',
        'admin/iCheck/icheck.min.js',
        'admin/fastclick/fastclick.min.js',
        'admin/app.min.js',
        'admin/sparkline/jquery.sparkline.min.js',
        'admin/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'admin/jvectormap/jquery-jvectormap-world-mill-en.js',
        'admin/slimScroll/jquery.slimscroll.min.js',
        'admin/chartjs/Chart.min.js',
        'admin/pages/dashboard2.js',
        'admin/demo.js'
    ], 'public/js/admin-js.js', 'public/js');

    mix.version(["public/css/admin-css.css", "public/js/admin-js.js"]);

});*/

gulp.task('imagemin', function() {
  return gulp.src(paths.images)
    .pipe(imagemin({ progressive: true }))
    .pipe(gulp.dest('public/img'));
});

gulp.task('fontmin', function() {
  fontmin().src(paths.fonts)
    .use(fontmin.otf2ttf())
    .use(fontmin.ttf2woff())
    .use(fontmin.ttf2eot())
    .use(fontmin.ttf2svg())
    .use(fontmin.css({
        fontPath: '../fonts/'
    }))
    .dest('public/fonts')
    .run();
});

gulp.task('libjsmin', function() {
  return gulp.src(paths.libjs)
    .pipe(uglify())
    .pipe(concat('lib.min.js'))
    .pipe(gulp.dest('public/js'));
});

gulp.task('jsmin', function() {
  return gulp.src(paths.js)
    .pipe(uglify())
    .pipe(concat('katalogram.min.js'))
    .pipe(gulp.dest('public/js'));
});

/*gulp.task('deferjsmin', function() {
  return gulp.src('resources/js/defer.js')
    .pipe(uglify())
    .pipe(concat('defer.min.js'))
    .pipe(gulp.dest('public/js'));
});
*/

gulp.task('less', function () {
  return gulp.src(paths.less)
    .pipe(less())
	.pipe(concat('uikit.css'))
    .pipe(gulp.dest('resources/css'));
});


gulp.task('cssmin', function () {
    return gulp.src(paths.css)
        .pipe(stylus())
        .pipe(cssmin({processImport: false}))
        .pipe(concat('katalogram.min.css'))
        .pipe(gulp.dest('public/css'));
});

gulp.task('htmlmin', function(cb) {
    return gulp.src(paths.html)
        .pipe(htmlmin({collapseWhitespace: true, removeComments: true}))
        .pipe(gulp.dest('public/views'))
});

gulp.task('exportmin', function(cb) {
    gulp.src('resources/export.html')
        .pipe(htmlmin({collapseWhitespace: true, removeComments: true}))
        .pipe(gulp.dest('public'));
    gulp.src(paths.exportjs)
        .pipe(uglify())
        .pipe(concat('export.min.js'))
        .pipe(gulp.dest('public/js'));
});

gulp.task('include', ['htmlmin'], function() {
    return gulp.src('resources/index.html')
        .pipe(include())
        .pipe(htmlmin({collapseWhitespace: true, removeComments: true }))
        .pipe(gulp.dest(''))
});

gulp.task('jsonmin', function () {
    return gulp.src(paths.json)
        .pipe(jsonmin())
        .pipe(gulp.dest('public/json'));
});

gulp.task('watch', function() {
  gulp.watch(paths.js, ['jsmin']);
  gulp.watch(paths.css, ['cssmin']);
  gulp.watch(paths.html, ['htmlpub']);
});

gulp.task('htmlpub', ['htmlmin', 'include']);
gulp.task('default', ['watch', 'imagemin', 'fontmin', 'libjsmin', 'jsmin', 'cssmin', 'htmlpub', 'exportmin']);
