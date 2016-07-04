var userCtrl = ['$state','$stateParams', '$scope', '$rootScope','$http', 'kgConfig',
  function($state, $stateParams,$scope, $rootScope, $http, kgConfig) {
	$scope.cropMeModal = UIkit.modal("#cropMeModal");
	$rootScope.bgNav = '';

	$http.get(
		//"json/member_profile.json"
		kgConfig.api+$stateParams.username
	).success(function(response) {
		$scope.user = response.user;
		$scope.user.catalog_count = Object.keys(response.user.user_product).length;
		$scope.user.collect_count = Object.keys(response.user.user_collect).length;
		$scope.user.contact_count = Object.keys(response.user.user_contact).length;
		$scope.user.connect_count = Object.keys(response.user.user_connect).length;;
		for (i=0;i<$scope.user.user_collect.length;i++) {
			$scope.user.user_collect[i].product.name = $scope.user.user_collect[i].product.name.substr(0,20);
		}
		//$scope.user.connect_count = Object.keys(response.user.user_connect).length;
		//console.log($scope.profile);
	}).catch(function(error) {
		//$state.go('home');
	});

	$scope.addContact = function(userId) {
		$http.post(kgConfig.api+'contact/'+userId)
		.success(function(response) {
			UIkit.notify(response.message, response.status);
			if (response.status =='success') $scope.user.is_contact = 1;
		})
	}
	$scope.removeContact = function(userId) {
		$http.delete(kgConfig.api+'contact/'+userId)
		.success(function(response) {
			UIkit.notify(response.message, response.status);
			if (response.status =='success') $scope.user.is_contact = 0;
		})
	}

}]
