var categoryCtrl = ['$http','$scope', '$location', 'Notification', function($http, $scope, $location, Notification) {

    $.AdminLTE.layout.fix();

	$scope.categories = [];
	$scope.totalCategories = 0;
	$scope.limit = 20;
	$scope.after = 0;
	$scope.onLoad = false;

    /*$scope.listType = function() {
        $http.get($scope.env.api+'category')
        .success(function (response) {
            $scope.type = response.type;
        })
    }*/

	$scope.listCategory = function() {
		$scope.onLoad = true;
		$http.get($scope.env.api+'category').success(function (response) {
			$scope.categories = response.categories;
			$scope.onLoad = false;
		})
	}

	$scope.editCategory = function(index) {
		$scope.input = $scope.categories[index];
		$("[data-widget='collapse']").click();
		$location.hash('categoryForm');
    };

	$scope.saveCategory = function(data, id) {
		$scope.onSave = true;
		$http.put($scope.env.api+'category/'+id, data)
		.success(function (response) {
            $scope.onSave = false;
			return true;
			//Notification({message: response.data.message}, response.status);
		})
	}

    $scope.listCategory();
}];
