var authCtrl = ['$scope', '$auth', '$state', 'Notification', function($scope, $auth, $state, Notification) {
	$scope.onLogin = false;
	$scope.login = function(form) {
		$scope.onLogin = true;
		$auth.login(form)
		  .then(function(response) {
		    // Redirect user here after a successful log in.
		    //console.log(response.token)
		  	$scope.getAuthUser();
		  	$state.go('dashboard');
            Notification({message: "login success"}, "success");
			$scope.onLogin = false;
		  })
		  .catch(function(response) {
             Notification({message: response.data.message}, response.data.status);
			 $scope.onLogin = false;
		  });
	}	
}];
