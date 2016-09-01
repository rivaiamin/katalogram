var config = [ '$stateProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider',
	function($stateProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider) {
	var loginRequired = ['$q', '$location', '$auth', function($q, $location, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.resolve();
      } else {
        $location.path('/login');
      }
      return deferred.promise;
    }];

    var skipIfLoggedIn = ['$q', '$auth', function($q, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.reject();
      } else {
        deferred.resolve();
      }
      return deferred.promise;
	}];

	$stateProvider.state('dashboard', {
		url:'/', 
		templateUrl: 'views/admin/dashboard.html',
		controller: 'homeCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('product', {
		url:'/product',
		templateUrl: 'views/admin/product.html',
		controller: 'productCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('category', {
		url:'/category',
		templateUrl: 'views/admin/category.html',
		controller: 'categoryCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('feedback', {
		url:'/feedback',
		templateUrl: 'views/admin/feedback.html',
		controller: 'feedbackCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('tag', {
		url: '/tag',
		templateUrl: 'views/admin/tag.html',
		controller: 'tagCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('criteria', {
		url: '/criteria',
		templateUrl: 'views/admin/criteria.html',
		controller: 'criteriaCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('page', {
		url: '/page',
		templateUrl: 'views/admin/page.html',
		controller: 'pageCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('login', {
		url:'/login',
		templateUrl: 'views/admin/login.html',
		controller: 'authCtrl',
		resolve: {
			skipIfLoggedIn: skipIfLoggedIn
		}
	}).state('user', {
		url: '/user',
		templateUrl: 'views/admin/user.html',
		controller: 'userCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	});
	//controller example
	/*.state('mapping', {
		url:'/admin/mapping',
		templateUrl: 'views/mapping/index.html',
		controller: 'adminMappingCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	})*/
	$locationProvider.html5Mode(true);
	$urlRouterProvider.otherwise('/');
	$authProvider.loginUrl = '/login/setup';
}]
