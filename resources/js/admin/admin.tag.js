var tagCtrl = ['$http','$scope', 'Notification', function($http, $scope, Notification) {
	$.AdminLTE.layout.fix();

    $scope.input = {};
    $scope.tagForm = {};
    $scope.tags = [];
    $scope.totalTags = 0;
    $scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;
	$scope.scrollLast = false;
	$scope.onLoad = false;

	$scope.searchTag = function(filter) {
		$scope.after = 0;
		$scope.tags = [];
		$scope.nextPage();
		$scope.filter = filter;
	}

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'tag/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			$scope.scrollBusy = false;
			for (var i = 0; i < response.tags.length; i++) {
				$scope.tags.push(response.tags[i]);
			}
			if (response.tags.length > 0) {
				$scope.after = response.tags[response.tags.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.tags);
        })
	}


	$scope.addTag = function(input) {
		$scope.onAdd = true;
		$http.post($scope.env.api+'tag', input)
		.success(function (response) {
            Notification({message: response.success}, 'success');
			$scope.tags.push(response.tag);
			$scope.input = {};
			$('#name').focus();
			$scope.onAdd = false;
		})
	}

	$scope.saveTag = function(data, id) {
		return $http.put($scope.env.api+'tag/'+id, data)
		.success(function (response){
			Notification({message: response.success}, 'success');
		});
	}

	$scope.deleteTag = function(id) {
		var index = $scope.indexSearch($scope.tags, id);
		if (confirm('delete tag?')) {
			$scope.onLoad = true;
			$http.delete($scope.env.api+'tag/'+id)
			.success(function (response) {
				Notification({message: response.success}, 'success');
				$scope.tags.splice(index, 1);
				$scope.onLoad = false;
			});
		}
	}

}];
