var userCtrl = ['$http','$scope', '$location', 'Notification','Upload',
    function($http, $scope, $location, Notification, Upload) {
	$.AdminLTE.layout.fix();

    $scope.onEdit = false;
    $scope.input = {};
    $scope.userAddForm = {};
    $scope.users = [];
    $scope.totalUsers = 0;
    $scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;
	$scope.scrollLast = false;

    /*$scope.listUser = function() {
        $http.get($scope.env.api+'user')
        .success(function (response) {
            $scope.users = response.user;
        });
    };*/

    /*$scope.getResultsPage = function(page) {
        $http.get($scope.env.api+'user/paging/'+page+'/'+$scope.limit)
        .success(function (response) {
            $scope.users = response.users;
            $scope.totalUsers = response.count;
        });
    };

    $scope.pageChanged = function(page) {
        $scope.getResultsPage(page);
    };*/

	$scope.searchUser = function(filter) {
		$scope.after = 0;
		$scope.users = [];
		$scope.nextPage();
		$scope.filter = filter;
	}

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'user/scroll/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			for (var i = 0; i < response.users.length; i++) {
				$scope.users.push(response.users[i]);
			}
            //$scope.users.push(response.users[0]);
			if (response.users.length > 0) {
				$scope.after = response.users[response.users.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			$scope.scrollBusy = false;
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.users);
        })
	}

    $scope.formUser = function() {
        $http.get($scope.env.api+'user/form')
        .success(function (response) {
            $scope.roles = response.roles;
        });
    };

    $scope.uploadPicture = function(isValid, file) {
        if (isValid) {
            $scope.onProgress2 = true;

            Upload.upload({
                url: $scope.env.api+'user/picture',
                method: 'POST',
                data: {
                    picture: file,
                }
            }).then(function (resp) {
                $scope.onProgress2 = false;
                $scope.input.picture = resp.data.picture;
            }, function (resp) {
                Notification({message: resp.message}, resp.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress2 = progressPercentage;
            });
	    }
    };

    $scope.resetUser = function() {
        $scope.input = {};
        $("[data-widget='collapse']").click();
    };

	$scope.saveUser = function(input) {
		$scope.onSave = true;
        if (input.id === undefined) {
            $http.post($scope.env.api+'user', input)
            .success(function (response) {
                Notification({message: response.message}, response.status);
                if (response.status == 'success') {
                    $scope.users.push(response.user);
                    //$scope.input.id = response.user.id;
                    $scope.input = {};
                    //$scope.fileicon = {};
                    //$('#name').focus();
                }
				$scope.onSave = false;
            });
        } else {
            //input.city_id = $scope.input.city.id;
            //input.user_type_id = $scope.input.user_type.id;

            //var index = $scope.indexSearch($scope.users, input.id);
            return $http.put($scope.env.api+'user/'+input.id, input)
            .then(function (response) {
                //$scope.users[index] = response.data.user[0];
				if (response.status == 200) {
                	Notification({message: "user data updated"}, "success");
					$scope.input = {};
					//$("[data-widget='collapse']").click();
				} else if (response.status == 500) {
                	Notification({message: "failed to update"}, "error");
				}
                //$scope.onEdit = false;
				$scope.onSave = false;
            });
        }
	};

    $scope.editUser = function(id) {
        $scope.onEdit = false;
        $http.get($scope.env.api+'user/'+id)
        .success(function (response) {
            //$scope.input = response.user;
            $scope.input.role_id = parseInt(response.user.roles[0].id);
			$scope.input.id = response.user.id;
			$scope.input.name = response.user.name;
			$scope.input.email = response.user.email;

            if ($(".box.box-default").hasClass('collapsed-box')) {
				$("[data-widget='collapse']").click();
			}
            $location.hash('userForm');
        });
    };

	/*$scope.saveUser = function(edit, id) {

	}*/

	$scope.deleteUser = function(id) {
		var index = $scope.indexSearch($scope.users, id);
		if (confirm('delete user?')) {
			$scope.onLoad = true;
			$http.delete($scope.env.api+'user/'+id)
			.success(function (response) {
				Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.type);
					$scope.users.splice(index, 1);
				}
				$scope.onLoad = false;
			});
		}
	};

    //$scope.listUser();
    //$scope.getResultsPage(1);
    $scope.formUser();
}];
