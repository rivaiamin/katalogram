var catalogCategoryCtrl = ['$scope', '$rootScope', '$stateParams', '$http', '$state', '$sce', '$location','kgConfig',
  function($scope, $rootScope, $stateParams, $http, $state, $sce, $location, kgConfig) {
	var slug = $stateParams.slug;
	$scope.filter.category = slug;

	$scope.catalogList();

	$http.get(kgConfig.api+'category').success(function(response) {
		$scope.categories = response.categories;

		var index = $scope.indexSearch($scope.categories, parseInt($stateParams.id));
		$scope.category = $scope.categories[index];
	});

}]
