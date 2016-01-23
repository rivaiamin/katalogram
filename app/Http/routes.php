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

    Route::get('foo', ['middleware' => 'role', function()
    {
        return "hanya untuk manager";
    }]);

	Route::get('/', [
        'as'    => 'dashboard',
        'uses'  => 'Admin\DashboardController@index'
    ]);

    /*user auth
    =================================================================*/

/*    // Authentication Routes...
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // Registration Routes...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');

*/    /*user
    =================================================================*/

    Route::get('user', [
        'as'    => 'user',
        'uses'  => 'Admin\UserController@index'
    ]);

    Route::get('user/create', [
        'as'    => 'user.create',
        'uses'  => 'Admin\UserController@create'
    ]);

    Route::get('user/{id}', [
        'as'    => 'user.id',
        'uses'  => 'Admin\UserController@show'
    ]);

    Route::post('user', [
        'as'    => 'user.store',
        'uses'  => 'Admin\UserController@store'
    ]);

    Route::get('user/{id}/edit', [
        'as'    => 'user.id.edit',
        'uses'  => 'Admin\UserController@edit'
    ]);   

    Route::patch('user/{id}', 'Admin\UserController@update');

    Route::get('user/{id}/delete', [
        'as'    => 'user.id.delete',
        'uses'  => 'Admin\UserController@destroy'
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

    /*route authencticate with jwt-auth
    =================================================================*/

    Route::resource('authenticate', 'Auth\AuthenticateController', ['only' => ['index']]);
    Route::post('member/login', 'Auth\AuthenticateController@authenticate');
    Route::post('member/register', 'Auth\AuthenticateController@store');
    
    /*route catalog list
    =================================================================*/

    Route::get('catalog', 'Server\CatalogController@index');

    Route::get('catalog/{id}/category', 'Server\CatalogController@categoryProduct');

    Route::post('catalog', 'Server\CatalogController@store');

    Route::post('catalog/{id}', 'Server\CatalogController@update');  

    Route::get('catalog/{id}/delete', 'Server\CatalogController@destroy'); 

    /*route product by id
    =================================================================*/

    Route::get('product/{id}', 'Server\ProductController@index');
});


/*route authenticate katalogram
======================================================================*/

Route::controllers([
    'auth'  => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController',
]);

