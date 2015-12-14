<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*route admin katalogram
======================================================================*/

Route::group([
    'domain' => 'admin.' . env('APP_DOMAIN')
], function() {

	Route::get('/', [
        'as'    => 'dashboard',
        'uses'  => 'admin\DashboardController@index'
    ]);

});


/*route server katalogram
======================================================================*/

Route::group([
    'domain' => 'server.' . env('APP_DOMAIN')
], function() {

	Route::get('/', [
        'as'    => 'dashboard',
        'uses'  => 'server\CatalogController@index'
    ]);

});