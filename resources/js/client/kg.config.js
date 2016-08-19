var config = ['$stateProvider', '$sceProvider', '$rootScopeProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', '$provide', 'kgConfig',
  function($stateProvider, $sceProvider, $rootScopeProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider, $provide, kgConfig) {

    var skipIfLoggedIn = ['$q', '$location', '$auth', function($q, $location, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        //deferred.reject();
		$location.path('/catalog');
      } else {
        deferred.resolve();
      }
      return deferred.promise;
	}];

	$stateProvider.state('home', {
		url:'/',
		templateUrl: 'homepage.html',
		controller: 'homeCtrl',
		resolve: {
			skipIfLoggedIn: skipIfLoggedIn
		}
	}).state('catalog', {
		url:'/catalog',
		templateUrl: 'catalog.list.html',
		controller: 'catalogCtrl'
	}).state('catalog.category', {
		url:'/category/:slug/:id',
		templateUrl: 'catalog.list.category.html',
		controller: 'catalogCategoryCtrl'
	}).state('catalog.view', {
		url:'/:productId/view',
		onEnter: [ '$stateParams', '$rootScope', function($stateParams, $rootScope) {
			$rootScope.catalogDetail($stateParams.productId);
		}],
		onExit: [ '$stateParams', '$rootScope', function($stateParams, $rootScope) {
			if ($rootScope.modalTemplate1 != "") $rootScope.modal1.hide();
			//console.log($stateParams.productId);
		}]
	}).state('catalog.detail', {
		url:'/:productId',
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

	$urlRouterProvider.otherwise('/');

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

	// this demonstrates how to register a new tool and add it to the default toolbar
	$provide.decorator('taOptions', ['$delegate', function(taOptions){
		// $delegate is the taOptions we are decorating
		// here we override the default toolbars and classes specified in taOptions.
		taOptions.forceTextAngularSanitize = true; // set false to allow the textAngular-sanitize provider to be replaced
		taOptions.keyMappings = []; // allow customizable keyMappings for specialized key boards or languages
		taOptions.toolbar = [
			['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
			['bold', 'italics', 'underline', 'ul', 'ol', 'redo', 'undo', 'clear'],
			['justifyLeft','justifyCenter','justifyRight', 'justifyFull'],
			['html', 'insertImage', 'insertLink', 'wordcount', 'charcount']
		];
		taOptions.classes = {
			focussed: 'focussed',
			toolbar: 'ui segment',
			toolbarGroup: 'ui basic buttons',
			toolbarButton: 'ui button',
			toolbarButtonActive: 'active',
			disabled: 'disabled',
			textEditor: 'ui segment',
			htmlEditor: 'ui segment'
		};
		return taOptions; // whatever you return will be the taOptions
	}]);
	// this demonstrates changing the classes of the icons for the tools for font-awesome v3.x
	$provide.decorator('taTools', ['$delegate', function(taTools){
		taTools.bold.iconclass = 'bold icon';
		taTools.italics.iconclass = 'italic icon';
		taTools.underline.iconclass = 'underline icon';
		taTools.ul.iconclass = 'unordered list icon';
		taTools.ol.iconclass = 'ordered list icon';
		taTools.undo.iconclass = 'undo icon';
		taTools.redo.iconclass = 'repeat icon';
		taTools.justifyLeft.iconclass = 'align left icon';
		taTools.justifyRight.iconclass = 'align right icon';
		taTools.justifyCenter.iconclass = 'align center icon';
		taTools.justifyFull.iconclass = 'align justify icon';
		taTools.clear.iconclass = 'remove circle icon';
		taTools.html.iconclass = 'code icon';
		taTools.insertLink.iconclass = 'linkify icon';
		taTools.insertImage.iconclass = 'file image outline icon';
		// there is no quote icon in old font-awesome so we change to text as follows
		delete taTools.quote.iconclass;
		taTools.quote.buttontext = 'quote';
		return taTools;
	}]);

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
