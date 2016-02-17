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

Route::group([//['middleware' => 'cors'],
    'domain' => 'api.' . env('APP_DOMAIN')
], function() {

    /*route authencticate with jwt-auth
    =================================================================*/

    Route::resource('authenticate', 'Auth\AuthenticateController', ['only' => ['index']]);
    Route::get('auth/user', 'Auth\AuthenticateController@getAuthenticatedUser');
    Route::get('auth/refresh', 'Auth\AuthenticateController@refresh');
    Route::post('member/login', 'Auth\AuthenticateController@login');
    Route::post('member/register', 'Auth\AuthenticateController@register');
    Route::post('auth/facebook', 'Auth\AuthenticateController@facebook');
    Route::post('auth/google', 'Auth\AuthenticateController@google');

    // categories
    Route::get('category', 'Server\CategoryController@index');
    
    /*route catalog list
    =================================================================*/

    Route::get('catalog', 'Server\CatalogController@index');
    Route::get('catalog/category/{categoryId}', 'Server\CatalogController@catalogCategory');
    Route::post('catalog', 'Server\CatalogController@createCatalog');
    Route::get('catalog/{productId}/edit', 'Server\CatalogController@editCatalog');
    Route::put('catalog/{productId}', 'Server\CatalogController@updateCatalog');  
    Route::delete('catalog/{productId}/delete', 'Server\CatalogController@destroy'); 
    Route::put('catalog/{productId}/logo', 'Server\CatalogController@logoUpload');
    Route::post('catalog/{productId}/preview', 'Server\CatalogController@previewUpload');
    Route::get('catalog/{productId}', 'Server\CatalogController@catalogDetail');
    Route::get('catalog/{productId}/export', 'Server\CatalogController@exportCatalog');
    Route::get('catalog/{productId}/view', 'Server\CatalogController@viewCatalog');
    Route::get('catalog/{tag}/search', 'Server\CatalogController@searchCatalog');

    /*route member
    =================================================================*/

    Route::get('{username}', 'Server\MemberController@memberProfile');
    Route::get('{username}/edit', 'Server\MemberController@editMember');
    Route::put('{username}', 'Server\MemberController@updateMember');
    Route::put('{username}/pict', 'Server\MemberController@changePict');

    /*route tag
    =================================================================*/

    Route::post('catalog/{productId}/tag', 'Server\TagController@addTag');
    Route::delete('catalog/{productId}/tag/{tagId}', 'Server\TagController@deleteTag');

    /*route preview
    =================================================================*/

    Route::post('catalog/{productId}/preview', 'Server\PreviewController@previewUpload');

    /*route feedback
    =================================================================*/

    Route::post('catalog/{productId}/feedback', 'Server\FeedbackController@giveFeedback');
    Route::post('feedback/{feedbackId}/respond/{respondType}', 'Server\FeedbackController@respondFeedback');
    Route::post('catalog/{productId}/collect', 'Server\FeedbackController@giveCollection');
    Route::put('catalog/{feedbackId}/endorse', 'Server\FeedbackController@setEndorse');

    /*route criteria
    =================================================================*/

    Route::post('catalog/{productId}/criteria', 'Server\CriteriaController@addCriteria');
    Route::delete('catalog/{productId}/criteria/{criteriaId}', 'Server\CriteriaController@deleteCriteria');
    
    /*route Rate
    =================================================================*/

    Route::post('catalog/{productId}/rate/{criteriaId}/{rateValue}', 'Server\RateController@giveRate');
    
    /*route connection
    =================================================================*/

    Route::post('connect/{username}', 'Server\ConnectionController@addConnection');
    Route::delete('connect/{username}', 'Server\ConnectionController@removeConnection');

});


/*route authenticate katalogram
======================================================================*/

Route::controllers([
    'auth'  => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController',
]);