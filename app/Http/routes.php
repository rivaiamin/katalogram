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
    'domain' => 'setup.' . env('APP_DOMAIN')
], function() {
    Route::post('/login/{role}', 'Auth\AuthenticateController@login')->where('role', '(setup)');
    Route::get('/', function () {
        return view('admin');
    });
    Route::get('{state}', function () {
        return view('admin');
    });
    Route::get('{state}/{sub}', function () {
        return view('admin');
    });
});



/*route server katalogram
======================================================================*/

Route::group([//['middleware' => 'cors'],
    'domain' => 'api.' . env('APP_DOMAIN')
], function() {

	Route::get('sitemap', function(){

		// create new sitemap object
		$sitemap = App::make("sitemap");

		// set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
		// by default cache is disabled
		$sitemap->setCache('laravel.sitemap', 60);

		// check if there is cached sitemap and build new only if is not
		if (!$sitemap->isCached())
		{
			 // add item to the sitemap (url, date, priority, freq)
			 $sitemap->add(env('APP_URL'), '2016-07-4T20:10:00+02:00', '1.0', 'daily');

			 // get users
			 $users = DB::table('users')->orderBy('created_at', 'desc')->get();
			 foreach ($users as $user) {
				if ($user->picture != '') {
					$images[0] = [
						'url' => 'http://files.'.env('APP_DOMAIN').'/user/picture/'.$user->picture,
						'title' => $user->name,
						'caption' => "foto profil ".$user->name
					];
					$sitemap->add(env('APP_URL').'/'.$user->name, $user->updated_at, '0.7', 'weekly', $images);
				} else {
					$sitemap->add(env('APP_URL').'/'.$user->name, $user->updated_at, '0.7', 'weekly');
				}
			 }

			 // get categories
			 $categories = DB::table('categories')->orderBy('created_at', 'desc')->get();
			 foreach ($categories as $category) {
				$sitemap->add(env('APP_URL').'/category/'.$category->slug.'/'.$category->id, $category->updated_at, '0.8', 'monthly');
			 }

			 // get product
			 $products = DB::table('products')->where('is_release', 1)->orderBy('created_at', 'desc')->get();
			 foreach ($products as $product) {
				 $images[0] = [
                    'url' => 'http://files.'.env('APP_DOMAIN').'/product/logo/'.$product->logo,
                    'title' => $product->name,
                    'caption' => $product->quote
                ];
				$sitemap->add(env('APP_URL').'/catalog/'.$product->id.'/view', $product->updated_at, '0.6', 'monthly', $images);
			 }
		}

		// show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
		$sitemap->store('xml', 'sitemap');
		return $sitemap->render('xml');
	});

	Route::get('user/form', 'Server\UserController@form');

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
    Route::get('catalog/category/{categoryId}/share', 'Server\CategoryController@share');
    Route::get('catalog/{productId}', 'Server\ProductController@detail');
    Route::get('catalog/{productId}/qrcode', 'Server\ProductController@qrcode');
    Route::get('catalog/{productId}/export', 'Server\ProductController@export');
    Route::get('catalog/{productId}/view', 'Server\ProductController@view');
	Route::get('catalog/{productId}/share', 'Server\ProductController@view');
    Route::get('catalog/{tag}/search', 'Server\ProductController@search');
    Route::get('catalog/{after}/{limit}', 'Server\ProductController@get')
		->where(['after'=>'[0-9]+','limit'=>'[0-9]+']);

	Route::get('tag', 'Server\TagController@index');
	Route::get('tag/{after}/{limit}', 'Server\TagController@get');
	Route::get('criteria', 'Server\CriteriaController@index');
	Route::get('criteria/{after}/{limit}', 'Server\CriteriaController@get');

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

		/*route product tag
		=================================================================*/
		Route::post('catalog/{productId}/tag', 'Server\ProductTagController@add');
		Route::delete('catalog/{productId}/tag/{name}', 'Server\ProductTagController@remove');

		/*route product criteria
		=================================================================*/
		Route::post('catalog/{productId}/criteria', 'Server\ProductCriteriaController@add');
		Route::delete('catalog/{productId}/criteria/{name}', 'Server\ProductCriteriaController@remove');

		/*route preview
		=================================================================*/
		//Route::post('catalog/{productId}/preview', 'Server\PreviewController@previewUpload');

		/*route feedback
		=================================================================*/
		Route::post('catalog/{productId}/feedback', 'Server\ProductFeedbackController@send');
		Route::delete('catalog/{productId}/feedback/{id}', 'Server\ProductFeedbackController@remove');
		Route::post('feedback/{feedbackId}/respond/{respondType}', 'Server\ProductFeedbackController@respond');
		Route::put('feedback/{feedbackId}/endorse', 'Server\ProductFeedbackController@setEndorse');


		/*route Rate
		=================================================================*/
		Route::post('catalog/{productId}/rate', 'Server\ProductCriteriaRateController@store');

		/*route connection
		=================================================================*/
		Route::post('contact/{contact_id}', 'Server\ContactController@addContact');
		Route::delete('contact/{contact_id}', 'Server\ContactController@removeContact');
	});

	Route::group(['middleware' => 'ability:admin|manager'], function () {

		//module dashboard
		Route::get('dashboard', 'Server\DashboardController@index');

		//module user
		Route::get('user', 'Server\UserController@index');
		Route::get('user/scroll/{after}/{limit}', 'Server\UserController@scroll');

		Route::get('feedback/scroll/{after}/{limit}', 'Server\ProductFeedbackController@get');
		Route::delete('product/{productId}/feedback/{id}', 'Server\ProductFeedbackController@remove');

		Route::get('product/scroll/{after}/{limit}', 'Server\ProductController@get');
		Route::delete('product/{id}', 'Server\ProductController@delete');

		// category
		Route::post('category','Server\CategoryController@add');
		Route::post('category/icon', 'Server\CategoryController@uploadIcon');
		Route::put('category/{id}', 'Server\CategoryController@update');
		Route::delete('category/{id}', 'Server\CategoryController@delete');

		// tag
		Route::post('tag','Server\TagController@add');
		Route::put('tag/{id}', 'Server\TagController@update');
		Route::delete('tag/{id}', 'Server\TagController@delete');

		// criteria
		Route::post('criteria','Server\CriteriaController@add');
		Route::put('criteria/{id}', 'Server\CriteriaController@update');
		Route::delete('criteria/{id}', 'Server\CriteriaController@delete');

	});

	Route::group(['middleware' => 'ability:admin'], function () {
		//user module
		Route::post('user', 'Server\UserController@add');
		Route::get('user/{id}', 'Server\UserController@edit');
        Route::put('user/{id}', 'Server\UserController@update');
        Route::delete('user/{id}', 'Server\UserController@delete');
	});

    Route::group(['middleware' => 'ability:member'], function () {

		/*route member
		=================================================================*/
		Route::get('{username}/edit', 'Server\UserController@editProfile');
		Route::put('{username}/profile', 'Server\UserController@updateProfile');
		Route::post('{username}/picture', 'Server\UserController@uploadPicture');
		Route::post('{username}/cover', 'Server\UserController@uploadCover');
		Route::post('{username}/link', 'Server\UserController@addLink');
		Route::delete('{username}/link/{id}', 'Server\UserController@removeLink');
		//Route::put('{username}/pict', 'Server\UserController@changePict');
		Route::put('{username}/{field}', 'Auth\AuthenticateController@change');

	});

	// User Profile
	Route::get('{username}', 'Server\UserController@profile');
	Route::get('{username}/share', 'Server\UserController@share');
	Route::get('{username}/catalog/view', 'Server\UserController@catalogView');


});


/*route authenticate katalogram
======================================================================*/

Route::controllers([
    'auth'  => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController',
]);
