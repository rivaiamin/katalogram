var authCtrl = ['$scope', '$auth', '$state', function($scope, $auth, $state) {	
	$scope.login = function(form) {
		$auth.login(form)
		  .then(function(response) {
		    // Redirect user here after a successful log in.
		    //console.log(response.token)
		  	//$scope.getAuthUser();
		  	$state.go('dashboard');
		    //UIkit.notify(response.data.message, response.status);
		  })
		  .catch(function(response) {
		    //UIkit.notify(response.data.message, response.status);
		  });
	}	
}];