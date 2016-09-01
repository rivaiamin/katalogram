var criteriaCtrl = ['$http','$scope', 'Notification', function($http, $scope, Notification) {
	$.AdminLTE.layout.fix();

    $scope.input = {};
    $scope.criteriaForm = {};
    $scope.criterias = [];
    $scope.totalCriterias = 0;
    $scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;
	$scope.scrollLast = false;

	$scope.searchCriteria = function(filter) {
		$scope.after = 0;
		$scope.criterias = [];
		$scope.nextPage();
		$scope.filter = filter;
	}

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'criteria/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			$scope.scrollBusy = false;
			for (var i = 0; i < response.criterias.length; i++) {
				$scope.criterias.push(response.criterias[i]);
			}
			if (response.criterias.length > 0) {
				$scope.after = response.criterias[response.criterias.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.criterias);
        })
	}


	$scope.addCriteria = function(input) {
		$scope.onAdd = true;
		$http.post($scope.env.api+'criteria', input)
		.success(function (response) {
            Notification({message: response.message}, response.status);
			if (response.status == 'success') {
				//console.log(response.type);
				$scope.criterias.push(response.criteria);
				$scope.input = {};
				$('#name').focus();
			}
			$scope.onAdd = false;
		})
	}

	$scope.saveCriteria = function(data, id) {
		return $http.put($scope.env.api+'criteria/'+id, data)
		.success(function (response) {
            Notification({message: response.data.message}, response.status);
		})
	}

	$scope.deleteCriteria = function(id) {
		var index = $scope.indexSearch($scope.type, id);
		if (confirm('delete criteria?')) {
			$scope.onLoad = true;
			$http.delete($scope.env.api+'criteria/'+id)
			.success(function (response) {
				Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.type);
					$scope.criterias.splice(index, 1);
				}
				$scope.onLoad = false;
			})
		}
	}

}];
