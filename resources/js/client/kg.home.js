var homeCtrl = ['$scope', '$stateParams', '$rootScope', '$http', '$state', '$auth', '$sce', '$location', 'kgConfig',
  function($scope, $stateParams, $rootScope, $http, $state, $auth, $sce, $location, kgConfig) {

	$scope.catalogs = [];
	$scope.limit = 5;
	$scope.after = 0;
	$scope.url = $location.absUrl();
	$rootScope.modalTemplate1 = "";

	  $http.get(kgConfig.api+'catalog/0/5').success(function (response) {
			for (var i = 0; i < response.catalogs.length; i++) {
				$scope.catalogs.push(response.catalogs[i]);
			}
        })
}];
