
//window.onload = function () { window.loading_screen.finish(); }

//angular app
var host = window.location.hostname;
if (host == 'www.katalogram.com') host = 'katalogram.com';

if (host == 'katalogram.dev') {
	fbid = '1506049499709287';
	googleid = '13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com';
} else if (host == 'katalogram.com') {
	fbid = '1496399374007633';
	googleid = '13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com';
}

var kgApp = angular.module('kgApp', ['ui.router', 'ngSanitize', 'satellizer', 'ngTouch','superswipe','angulartics', 'angulartics.google.analytics', 'ui-notification' ]);
kgApp
// route angular
.constant('kgConfig', {
	'site': '//'+host+'/',
	'api': '//api.'+host+'/',
	'files': '//files.'+host+'/',
	'embedly': '8081dea79e164014bcd7cd7e1ab2363a',
	'fb': fbid,
	'google': googleid
})
.config(['$httpProvider', '$authProvider', '$locationProvider', 'kgConfig',
  function($httpProvider, $authProvider, $locationProvider, kgConfig) {

	//$locationProvider.html5Mode(true);
	//$httpProvider.defaults.useXDomain = true;

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

}])

//main controller
.controller('kgLandingCtrl', ['$scope', '$rootScope', '$http', '$state', '$auth', '$sce', '$location', '$interval', 'Notification', 'kgConfig',
function($scope, $rootScope, $http, $state, $auth, $sce, $location, $interval, Notification, kgConfig) {
	$rootScope.api = kgConfig.api;
	$rootScope.files = kgConfig.files;

	$scope.authenticate = function(provider) {
		$auth.authenticate(provider)
		  .then(function(response) {
		  	//$scope.getAuthUser();
			if (response.status == 'success')  {
				$('#callAct').modal('hide');
				$('#shareAct').modal('show');
			}
			Notification({message: response.data.message}, response.data.status)
		  })
		  .catch(function(error) {
		  	//UIkit.notify(response.message);
			Notification({message: error.data.message}, 'error')
		  });
	};

	$scope.subscribe = function(email) {
		$scope.isAction = true;
		$http.post(kgConfig.api+"auth/subscribe", {email: email}
		).success(function(response){
			if (response.status == 'success') {
				$('#callAct').modal('hide');
				$('#shareAct').modal('show');
			}
			$scope.isAction = false;
			Notification({message: response.message}, response.status);
		});
    };

	$scope.shareTo = function(media) {
		var url = window.location.href;
		if (media == 'facebook') var share_url = 'https://www.facebook.com/sharer.php?u='+url;
		else if (media == 'twitter') var share_url = 'https://twitter.com/home?status='+url;
		else if (media == 'google') var share_url = 'https://plus.google.com/share?url='+url;

		window.open(share_url, 'shareCatalog', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
		return false;
	}
}]);

$(document).ready(function() {
  // fix menu when passed
  /*$('.masthead')
	.visibility({
	  once: false,
	  onBottomPassed: function() {
		$('.fixed.menu').transition('fade in');
	  },
	  onBottomPassedReverse: function() {
		$('.fixed.menu').transition('fade out');
	  }
	})
  ;*/

  // create sidebar and attach to menu open
  /*$('.ui.sidebar').sidebar('attach events', '.toc.item');*/
  $('.menu .item').tab();
  $('#callAct').modal('attach events', '#callActBtn', 'show');
  //$('#shareAct').modal();

	$("#morphext1").Morphext({
		animation: "fadeInDown",
		separator: ",",
		speed: 8000
	});
	$("#morphext2").Morphext({
		animation: "fadeInDown",
		separator: ",",
		speed: 2000
	});
});



/* smartsupp */
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'cc1fd97b1ddc57f93720906a8da2de07d915ce03';
window.smartsupp||(function(d) {
	var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	c.type='text/javascript';c.charset='utf-8';c.async=true;
	c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);

/* Chatra.io */
/*(function(d, w, c) {
    w.ChatraID = 'LKxAZDW9MYtH5KbSs';
    var s = d.createElement('script');
    w[c] = w[c] || function() {
        (w[c].q = w[c].q || []).push(arguments);
    };
    s.async = true;
    s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
    + '//call.chatra.io/chatra.js';
    if (d.head) d.head.appendChild(s);
})(document, window, 'Chatra');*/

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1496399374007633";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-83303735-1', 'auto');
ga('send', 'pageview');
