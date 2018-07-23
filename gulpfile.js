"use strict";

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

var gulp = require('gulp');
var requireDir = require('require-dir');

requireDir("./resources/gulp");

//gulp.task('htmlpub', ['htmlmin', 'include']);
//gulp.task('default', ['back-watch', 'back-imagemin', 'back-fontmin', 'back-libjsmin', 'back-jsmin', 'back-cssmin', 'back-htmlmin', 'back-jsonmin']);
