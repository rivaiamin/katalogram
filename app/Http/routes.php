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

    /*user
    =================================================================*/

    Route::get('user', [
        'as'    => 'user',
        'uses'  => 'admin\UserController@index'
    ]);

    Route::get('user/{id}', [
        'as'    => 'user.id',
        'uses'  => 'admin\UserController@show'
    ]);

    Route::get('user/create', [
        'as'    => 'user.create',
        'uses'  => 'admin\UserController@create'
    ]);

    Route::post('user', [
        'as'    => 'user.store',
        'uses'  => 'admin\UserController@store'
    ]);

    Route::get('user/{id}/edit', [
        'as'    => 'user.id.edit',
        'uses'  => 'admin\UserController@edit'
    ]);   

    Route::patch('user/{id}', 'Admin\UserController@update');

    Route::get('user/{id}/delete', [
        'as'    => 'user.id.delete',
        'uses'  => 'admin\UserController@destroy'
    ]); 
    /*Route::patch('user/{id}', [
        'as'    => 'user.id',
        'uses'  => 'admin\UserController@update'
    ]); */


});


/*route server katalogram
======================================================================*/

Route::group([
    'domain' => 'api.' . env('APP_DOMAIN')
], function() {

	Route::get('/', [
        'as'    => 'dashboard',
        'uses'  => 'server\CatalogController@index'
    ]);

});