var schoolTypeCtrl = ['$http','$scope', 'Notification', function($http, $scope, Notification) {

    $.AdminLTE.layout.fix();

	$scope.types = [];
	$scope.totalTypes = 0;
	$scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;

    /*$scope.listType = function() {
        $http.get($scope.env.api+'school/type')
        .success(function (response) {
            $scope.type = response.type;
        })
    }*/

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'school/type/scroll/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			for (var i = 0; i < response.types.length; i++) {
				$scope.types.push(response.types[i]);
			}
            //$scope.types.push(response.types[0]);
			if (response.types.length > 0) {
				$scope.after = response.types[response.types.length - 1].id;
				$scope.scrollBusy = false;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.types);
        })
	}

	$scope.addType = function(input) {
		$scope.onAdd = true;
		$http.post($scope.env.api+'school/type', input)
		.success(function (response) {
            Notification({message: response.message}, response.status);
			if (response.status == 'success') {
				//console.log(response.type);
				$scope.types.push(response.type);
				$scope.input = {};
				$('#code').focus();
			}
			$scope.onAdd = false;
		})
	}
	$scope.saveType = function(data, id) {
		$scope.onSave = true;
		$http.put($scope.env.api+'school/type/'+id, data)
		.success(function (response) {
            $scope.onSave = false;
			return true;
			//Notification({message: response.data.message}, response.status);
		})
	}
	$scope.deleteType = function(id) {
		var index = $scope.indexSearch($scope.types, id);
		if (confirm('delete type?')) {
			$scope.onDelete = true;
			$http.delete($scope.env.api+'school/type/'+id)
			.success(function (response) {
				Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.type);
					$scope.types.splice(index, 1);
				}
				$scope.onDelete = false;
			})
		}
	}

    //$scope.listType();
}];
