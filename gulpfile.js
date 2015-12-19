var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// web less

elixir(function(mix) {

    // admin less
    mix.less('admin.less', 'public/css/admin/');

    mix.styles([
        'admin/bootstrap.min.css',
        'admin/app.css',
        'admin/jquery-jvectormap-1.2.2.css'
    ], 'public/css/admin-css.css', 'public/css');

    mix.scripts([
        'admin/jQuery/jQuery-2.1.4.min.js',
        'admin/bootstrap.min.js'/*,
        'admin/iCheck/icheck.min.js',
        'admin/fastclick/fastclick.min.js',
        'admin/app.min.js',
        'admin/sparkline/jquery.sparkline.min.js',
        'admin/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'admin/jvectormap/jquery-jvectormap-world-mill-en.js',
        'admin/slimScroll/jquery.slimscroll.min.js',
        'admin/chartjs/Chart.min.js',
        'admin/pages/dashboard2.js',
        'admin/demo.js'*/
    ], 'public/js/admin-js.js', 'public/js');

    mix.version(["public/css/admin-css.css", "public/js/admin-js.js"]);

});