var feedbackCtrl = ['$http','$scope', 'Notification', function($http, $scope, Notification) {
	$.AdminLTE.layout.fix();

    $scope.onEdit = false;
    $scope.input = {};
    $scope.feedbackAddForm = {};
    $scope.feedbacks = [];
    $scope.totalFeedbacks = 0;
    $scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;
	$scope.scrollLast = false;

	$scope.searchFeedback = function(filter) {
		$scope.after = 0;
		$scope.feedbacks = [];
		$scope.nextPage();
		$scope.filter = filter;
	}

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'feedback/scroll/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			$scope.scrollBusy = false;
			for (var i = 0; i < response.feedbacks.length; i++) {
				$scope.feedbacks.push(response.feedbacks[i]);
			}
            //$scope.feedbacks.push(response.feedbacks[0]);
			if (response.feedbacks.length > 0) {
				$scope.after = response.feedbacks[response.feedbacks.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.feedbacks);
        })
	}

	$scope.deleteFeedback = function(id) {
		var index = $scope.indexSearch($scope.feedbacks, id);
		if (confirm('delete feedback?')) {
			$scope.onLoad = true;
			$http.delete($scope.env.api+'product/'+$scope.feedbacks[index].product_id+'/feedback/'+id)
			.success(function (response) {
				Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.type);
					$scope.feedbacks.splice(index, 1);
				}
				$scope.onLoad = false;
			});
		}
	};
}];
