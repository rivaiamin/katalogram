var config = ['$stateProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', 'kgConfig',
  function($stateProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider, kgConfig) {
	$stateProvider.state('home', {
		url:'/',
		templateUrl: 'catalog.list.html',
		controller: 'catalogCtrl'
	}).state('catalog', {
		url:'/catalog',
		templateUrl: 'catalog.list.html',
		controller: 'catalogCtrl'
	}).state('catalogCategory', {
		url:'/catalog/category/:categoryId',
		templateUrl: 'catalog.list.html',
		controller: 'catalogCtrl'
	}).state('catalogDetail', {
		url:'/catalog/:productId',
		templateUrl: 'catalog.detail.html',
		controller: 'catalogCtrl'
	}).state('catalogEdit', {
		url:'/catalog/:productId/edit',
		templateUrl: 'catalog.edit.html',
		controller: 'catalogEditCtrl'
	}).state('profile', {
		url:'/{username:[a-zA-Z1-9.-]*}',
		templateUrl: 'user.profile.html',
		controller: 'userCtrl'
	}).state('editProfile', {
		url:'/:username/edit',
		templateUrl: 'user.edit.html',
		controller: 'userEditCtrl'
	});

	$locationProvider.html5Mode(true);
	$urlRouterProvider.otherwise('/catalog');
	$httpProvider.defaults.useXDomain = true;

	$authProvider.loginUrl = kgConfig.api+'auth/login';
	$authProvider.signupUrl = kgConfig.api+'auth/register';
	//embedlyServiceProvider.setKey('8081dea79e164014bcd7cd7e1ab2363a');

	$authProvider.facebook({
	  //for development
      //clientId: '1496399374007633', // for live
      clientId: '1496399374007633',
      url: kgConfig.api+'auth/facebook'
    });

    $authProvider.google({
      clientId:'13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com',
      url: kgConfig.api+'auth/google'
    });

	/*envServiceProvider.config({
		domains: {
			development: ['localhost', 'katalogram.dev'],
			production: ['202.150.213.147', 'katalogram.com', 'www.katalogram.com']
		},
		vars: {
			development: {
				site: '//katalogram.dev/',
				api: '//api.katalogram.dev/',
				file: '//files.katalogram.dev/',

			},
			production: {
				site: '//katalogram.com/',
				api: '//api.katalogram.com/',
				file: '//files.katalogram.com/'
			}
		}
	});*/

	// run the environment check, so the comprobation is made
	// before controllers and services are built
	//envServiceProvider.check();
}];
