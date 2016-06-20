var catalogCtrl = ['$scope', '$rootScope', '$http', '$location', '$stateParams','kgConfig',
  function($scope, $rootScope, $http, $location, $stateParams, kgConfig) {

	$scope.catalogs = [];
	$scope.scrollBusy = false;
	$scope.limit = 12;
	$scope.after = 0;
	$scope.onSearch = false;
	$scope.filter = {};
	$scope.url = $location.absUrl();
	$rootScope.bgNav = '';

	var categoryId = $stateParams.categoryId;

	if (categoryId != null) $scope.filter.category = categoryId;
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
				$scope.scrollBusy = false;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.catalogs);
        })
	}
}]
