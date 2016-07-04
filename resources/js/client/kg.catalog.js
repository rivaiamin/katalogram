var catalogCtrl = ['$scope', '$rootScope', '$stateParams', '$http', '$state', '$sce', '$location','kgConfig',
  function($scope, $rootScope, $stateParams, $http, $state, $sce, $location, kgConfig) {

	$scope.catalogs = [];
	$scope.scrollBusy = false;
	$scope.limit = 8;
	$scope.after = 0;
	$scope.onSearch = false;
	$scope.filter = {};
	$scope.url = $location.absUrl();
	$rootScope.bgNav = '';
	$rootScope.modalTemplate1 = "";

	/*$http.get(kgConfig.api+route)
	.success(function(response) {
		$scope.catalogs = response.catalogs;
	});*/

	$scope.catalogList = function() {
		//console.log($scope.filter);
		$scope.scrollBusy = true;
		$http.get(kgConfig.api+'catalog/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			for (var i = 0; i < response.catalogs.length; i++) {
				$scope.catalogs.push(response.catalogs[i]);
			}
            //$scope.catalogs.push(response.catalogs[0]);
			if (response.catalogs.length > 0) {
				$scope.after = response.catalogs[response.catalogs.length - 1].id;
				setTimeout($scope.scrollBusy = false, 10000);
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.catalogs);
        })
	}
	// TODO: https://github.com/angular-ui/ui-router/wiki/Frequently-Asked-Questions#how-to-open-a-dialogmodal-at-a-certain-state
    //if ($stateParams.productId != null) $scope.catalogDetail($stateParams.productId);
}]
