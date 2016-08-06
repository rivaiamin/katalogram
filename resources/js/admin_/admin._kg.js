var kgCtrl = ['$scope','$rootScope','$auth','$state','envService','Notification',
              function($scope,$rootScope,$auth,$state,envService,Notification) {

    $rootScope.env = envService.read('all');

	$scope.isAuthenticated = function() {
	  return $auth.isAuthenticated();
	};

	$scope.logout = function() {
		$auth.logout();
		$state.go('login');
	}

	$scope.indexSearch = function(array, id) {
		return array.map(function(el) {
		  return el.id;
		}).indexOf(id);
    }
}];
