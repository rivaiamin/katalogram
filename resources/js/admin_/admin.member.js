var memberCtrl = ['$http','$scope', 'Upload', 'Notification', function($http, $scope, Upload, Notification) {
	$scope.currentPage = 1;
	$scope.limit = 10;

    $scope.listMember = function() {
        $http.get($scope.env.api+'member')
        .success(function (response) {
            $scope.member = response.member;
        })
    }
    $scope.listMember();

    $scope.deleteMember = function(id) {
		var index = $scope.indexSearch($scope.category, id);
		if (confirm('delete category?')) {
			$http.delete($scope.env.api+'category/'+id)
			.success(function (response) {
                Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.category);
					$scope.category.splice(index, 1);
				}
			})
		}
	}

}];
