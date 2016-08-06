var config = ['$stateProvider', '$sceProvider', '$rootScopeProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', 'kgConfig',
  function($stateProvider, $sceProvider, $rootScopeProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider, kgConfig) {

	$stateProvider.state('catalog', {
		url:'/',
		templateUrl: 'catalog.list.html',
		controller: 'catalogCtrl'
	}).state('catalog.category', {
		url:'category/:slug/:id',
		templateUrl: 'catalog.list.category.html',
		controller: 'catalogCategoryCtrl'
	}).state('catalog.view', {
		url:'catalog/:productId/view',
		onEnter: [ '$stateParams', '$rootScope', function($stateParams, $rootScope) {
			$rootScope.catalogDetail($stateParams.productId);
		}],
		onExit: [ '$stateParams', '$rootScope', function($stateParams, $rootScope) {
			if ($rootScope.modalTemplate1 != "") $rootScope.modal1.hide();
			//console.log($stateParams.productId);
		}]
	}).state('catalog.detail', {
		url:'catalog/:productId',
		templateUrl: 'catalog.detail.html'
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

	$urlRouterProvider.otherwise('/catalog');

	$locationProvider.html5Mode(true);
	$httpProvider.defaults.useXDomain = true;

	$authProvider.loginUrl = kgConfig.api+'auth/login';
	$authProvider.signupUrl = kgConfig.api+'auth/register';
	//embedlyServiceProvider.setKey('8081dea79e164014bcd7cd7e1ab2363a');

	$authProvider.facebook({
	  //for development
      //clientId: '1496399374007633', // for live
      clientId: kgConfig.fb,
      url: kgConfig.api+'auth/facebook'
    });

    $authProvider.google({
      clientId: kgConfig.google,
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
