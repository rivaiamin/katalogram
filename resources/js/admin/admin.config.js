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
	}).state('school', {
		url:'/school',
		templateUrl: 'views/admin/school.html',
		controller: 'schoolCtrl',
		resolve: {
			loginRequired: loginRequired
		}
	}).state('school-type', {
		url:'/school/type',
		templateUrl: 'views/admin/school.type.html',
		controller: 'schoolTypeCtrl',
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
	}).state('label', {
		url: '/label',
		templateUrl: 'views/admin/label.html',
		controller: 'labelCtrl',
		resolve: {
			loginRequired: loginRequired
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
