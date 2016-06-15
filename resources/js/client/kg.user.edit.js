var userEditCtrl =  ['$stateParams','$scope', '$rootScope','$http', 'kgConfig',
  function($stateParams, $scope, $rootScope, $http, kgConfig) {

	$http({
		method: "GET",
		//url: "json/member_profile.json"
		url: kgConfig.api+$stateParams.username+'/edit',
	}).success(function(response) {
		$scope.user = response.user;
		$scope.user.profile = response.user.user_profile;
		$scope.user.profile.born = new Date(+$scope.user.profile.born*1000);
		$('.ui.accordion').accordion('refresh');
		//console.log(Date.parse('Aug 9, 1995'));
		//console.log($scope.memberProfile.member);
	});

	$scope.updateProfile = function(profile) {
		profile.born = Date.parse(profile.born)/1000;
		$http.put(kgConfig.api+$rootScope.user.name+'/profile', profile).success(function(response) {
			UIkit.notify(response.message, response.status);
		})
	}

	$scope.changeUser = function(field, input) {
		if (field == 'name') data = { name: input };
		else if (field == 'email') data = { email: input };
		else if (field == 'password') data = input;

		$http.put(kgConfig.api+$rootScope.user.name+'/'+field, data).success(function(response) {
			UIkit.notify(response.data.success, response.status);
		}).catch(function (error){
			UIkit.notify(error.data.error, error.status);
		})
	}
}]
