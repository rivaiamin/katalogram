var catalogCtrl = ['$scope', '$rootScope', '$stateParams', '$http', '$state', '$sce', '$location','kgConfig',
  function($scope, $rootScope, $stateParams, $http, $state, $sce, $location, kgConfig) {

	$scope.catalogs = [];
	$scope.scrollBusy = false;
	$scope.scrollLast = false;
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

	$rootScope.$on("searchCatalog", function(){
		$scope.after = 0;
		$scope.catalogs = [];
		$scope.filter.tags = $rootScope.filter.tags;
		$scope.catalogList();
	});

	$scope.catalogList = function() {
		$scope.scrollBusy = true;
		$http.get(kgConfig.api+'catalog/'+$scope.after+'/'+$scope.limit, {
			params: { category: $scope.filter.category, tags: JSON.stringify($scope.filter.tags) }
		}).success(function (response) {
			for (var i = 0; i < response.catalogs.length; i++) {
				$scope.catalogs.push(response.catalogs[i]);
			}
            //$scope.catalogs.push(response.catalogs[0]);
			if (response.catalogs.length > 0) {
				$scope.after = response.catalogs[response.catalogs.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			$scope.scrollBusy = false;
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.catalogs);
        })
	}

	// TODO: https://github.com/angular-ui/ui-router/wiki/Frequently-Asked-Questions#how-to-open-a-dialogmodal-at-a-certain-state
    //if ($stateParams.productId != null) $scope.catalogDetail($stateParams.productId);
}]
