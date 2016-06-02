var userCtrl = ['$state','$stateParams', '$scope', '$rootScope','$http', 'kgConfig',
  function($state, $stateParams,$scope, $rootScope, $http, kgConfig) {
	$scope.cropMeModal = UIkit.modal("#cropMeModal");
	$http.get(
		//"json/member_profile.json"
		kgConfig.api+$stateParams.username
	).success(function(response) {
		$scope.user = response.user;
		$scope.user.catalog_count = Object.keys(response.user.user_product).length;
		$scope.user.collect_count = Object.keys(response.user.user_collect).length;
		$scope.user.contact_count = Object.keys(response.user.user_contact).length;
		$scope.user.connect_count = 20;
		//$scope.user.connect_count = Object.keys(response.user.user_connect).length;
		//console.log($scope.profile);
	}).catch(function(error) {
		//$state.go('home');
	});

	$scope.savePict = function(filename) {
		$http.put(kgConfig.api+$rootScope.user.name+'/pict', {
			user_pict : filename
		}).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.cropMeModal.hide();
			$scope.profile.user.user_pict = filename;
		});
	};
	$scope.addConnect = function(userId) {
		$http.post(kgConfig.api+'connect/'+userId)
		.success(function(response) {
			UIkit.notify(response.data.message, response.status);
		})
	}
	$scope.removeConnect = function(userId) {
		$http.delete(kgConfig.api+'connect/'+userId)
		.success(function(response) {
			UIkit.notify(response.data.message, response.status);
		})
	}
	$scope.$on("cropme:done", function(ev, response, cropmeEl) {
		var blob = response.croppedImage;
		//$scope.image = blob;
		$http({
			method: "POST",
			url: kgConfig.files+"saveavatar.php",
			data: blob,
			headers: {
				'Content-Type': blob.type
			}
		}).success(function(response){
			if (response.status=='success') {
				$scope.savePict(response.filename, blob);

			}
		})
	});

}]
