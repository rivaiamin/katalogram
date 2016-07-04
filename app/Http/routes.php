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
    'domain' => 'admin.' . env('APP_DOMAIN'), 
], function() {

   /* Route::get('foo', ['middleware' => 'role', function()
    {
        return "hanya untuk manager";
    }]);*/

    Route::get('/kalana', 'Admin\DashboardController@template');
    Route::post('/kalana/auth', 'Auth\AuthenticateController@login');
	Route::get('/', [
        'as'    => 'dashboard',
        //'middleware' => ['ability:admin|manager'],
        'uses'  => 'Admin\DashboardController@template'
    ]);

    Route::get('/{state}', [
        'as'    => 'module',
        'middleware' => ['role:admin|manager'],
        'uses'  => 'Admin\DashboardController@template'
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
	/* Route::get('user', [
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

    Route::put('user/{id}', 'Admin\UserController@updateProfile');

    Route::delete('user/{id}', [
        'as'    => 'user.id.delete',
        'uses'  => 'Admin\UserController@destroy'
    ]);
    Route::patch('user/{id}', [
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
    
    // user auth front-end
    Route::resource('authenticate', 'Auth\AuthenticateController', ['only' => ['index']]);
    Route::get('auth/user', 'Auth\AuthenticateController@getAuthUser');
    Route::get('auth/refresh', 'Auth\AuthenticateController@refresh');
    Route::post('auth/login', 'Auth\AuthenticateController@login');
    Route::post('auth/register', 'Auth\AuthenticateController@register');
    Route::post('auth/facebook', 'Auth\AuthenticateController@facebook');
    Route::post('auth/google', 'Auth\AuthenticateController@google');

     // categories
    Route::get('category', 'Server\CategoryController@index');
    Route::get('category/{id}', 'Server\CategoryController@detail');

	/*route catalog list
    =================================================================*/
    Route::get('catalog', 'Server\ProductController@get');
    Route::get('catalog/category/{categoryId}', 'Server\ProductController@index');
    Route::get('catalog/{productId}', 'Server\ProductController@detail');
    Route::get('catalog/{productId}/export', 'Server\ProductController@export');
    Route::get('catalog/{productId}/view', 'Server\ProductController@view');
	Route::get('catalog/{productId}/export', 'Server\ProductController@export');
    Route::get('catalog/{tag}/search', 'Server\ProductController@search');
    Route::get('catalog/{after}/{limit}', 'Server\ProductController@get')
		->where(['after'=>'[0-9]+','limit'=>'[0-9]+']);

	Route::get('tags', 'Server\TagController@index');
	Route::get('criterias', 'Server\CriteriaController@index');

	// User Profile
	Route::get('{username}', 'Server\UserController@profile');

	Route::group(['middleware' => 'ability:admin|manager|member'], function () {

		// product
		Route::post('catalog', 'Server\ProductController@create');
		Route::get('catalog/{productId}/edit', 'Server\ProductController@edit');
		Route::put('catalog/{productId}', 'Server\ProductController@update');
		Route::delete('catalog/{productId}', 'Server\ProductController@delete');
		Route::post('catalog/{productId}/logo', 'Server\ProductController@logoUpload');
		Route::post('catalog/{productId}/picture', 'Server\ProductController@pictureUpload');

		// route collect
		Route::post('collect/{productId}', 'Server\UserCollectController@add');
		Route::delete('collect/{productId}', 'Server\UserCollectController@remove');

		/*route member
		=================================================================*/
		Route::get('{username}/edit', 'Server\UserController@edit');
		Route::put('{username}/profile', 'Server\UserController@updateProfile');
		Route::post('{username}/picture', 'Server\UserController@uploadPicture');
		Route::post('{username}/cover', 'Server\UserController@uploadCover');
		Route::post('{username}/link', 'Server\UserController@addLink');
		Route::delete('{username}/link/{id}', 'Server\UserController@removeLink');
		//Route::put('{username}/pict', 'Server\UserController@changePict');
		Route::put('{username}/{field}', 'Auth\AuthenticateController@change');

		/*route product tag
		=================================================================*/
		Route::post('catalog/{productId}/tag', 'Server\ProductTagController@add');
		Route::delete('catalog/{productId}/tag/{tagId}', 'Server\ProductTagController@remove');

		/*route product criteria
		=================================================================*/
		Route::post('catalog/{productId}/criteria', 'Server\ProductCriteriaController@add');
		Route::delete('catalog/{productId}/criteria/{criteriaId}', 'Server\ProductCriteriaController@remove');

		/*route preview
		=================================================================*/
		//Route::post('catalog/{productId}/preview', 'Server\PreviewController@previewUpload');

		/*route feedback
		=================================================================*/
		Route::post('catalog/{productId}/feedback', 'Server\ProductFeedbackController@send');
		Route::delete('catalog/{productId}/feedback/{id}', 'Server\ProductFeedbackController@remove');
		Route::post('feedback/{feedbackId}/respond/{respondType}', 'Server\ProductFeedbackController@respond');
		Route::put('catalog/{feedbackId}/endorse', 'Server\ProductFeedbackController@setEndorse');


		/*route Rate
		=================================================================*/
		Route::post('catalog/{productId}/rate', 'Server\ProductCriteriaRateController@store');

		/*route connection
		=================================================================*/
		Route::post('contact/{contact_id}', 'Server\ContactController@addContact');
		Route::delete('contact/{contact_id}', 'Server\ContactController@removeContact');
	});

	Route::group(['middleware' => 'ability:admin|manager'], function () {

		// backend crud user
		Route::get('user', 'Server\MemberController@index');
		Route::delete('user/{memberId}/delete', 'Server\MemberController@deleteMember');

		// category
		Route::post('category','Server\CategoryController@add');
		Route::post('category/icon', 'Server\CategoryController@uploadIcon');
		Route::put('category/{id}', 'Server\CategoryController@update');
		Route::delete('category/{id}', 'Server\CategoryController@delete');
	});

});


/*route authenticate katalogram
======================================================================*/

Route::controllers([
    'auth'  => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController',
]);
