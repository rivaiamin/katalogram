var config = [ '$stateProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', 'envServiceProvider', function ($stateProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider, envServiceProvider) {
	
	var loginRequired = ['$q', '$location', '$auth', function($q, $location, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.resolve();
      } else {
        $location.path('/kalana');
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
	}).state('member', {
		url:'/member', 
		templateUrl: 'views/admin/member.html',
		controller: 'memberCtrl',
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
	}).state('login', {
		url:'/kalana', 
		templateUrl: 'views/admin/login.html',
		controller: 'authCtrl',
		resolve: {
			skipIfLoggedIn: skipIfLoggedIn
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
	
	envServiceProvider.config({
		domains: {
			development: ['localhost', 'katalogram.dev', 'admin.katalogram.dev'],
			production: ['202.150.213.147', 'katalogram.com', 'admin.katalogram.com']
		},
		vars: {
			development: {
				site: '//katalogram.dev/',
				api: '//api.katalogram.dev/',
				admin: '//admin.katalogram.dev/',
				file: '//files.katalogram.dev/'
				
			},
			production: {
				site: '//katalogram.com/',
				api: '//api.katalogram.com/',
				admin: '//admin.katalogram.com/',
				file: '//files.katalogram.com/'
			}
		}
	});

	// run the environment check, so the comprobation is made 
	// before controllers and services are built 
	envServiceProvider.check();

	$locationProvider.html5Mode(true);
	$urlRouterProvider.otherwise('/');
	
	$authProvider.loginUrl = '/kalana/auth';
	
}]