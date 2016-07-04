var userEditCtrl =  ['$stateParams','$scope', '$rootScope', '$state', '$http', 'kgConfig', 'Upload',
  function($stateParams, $scope, $rootScope, $state, $http, kgConfig, Upload) {

	$scope.isSaving = false;
	$scope.isAddLink = false;
	$scope.progress1 = false;
	$scope.progress2 = false;

	if ($scope.auth == undefined) $state.go('profile');
	if ($scope.auth.name != $stateParams.username) $state.go('profile');

	$http({
		method: "GET",
		//url: "json/member_profile.json"
		url: kgConfig.api+$stateParams.username+'/edit',
	}).success(function(response) {
		$scope.edit = response.user;
		$scope.links = response.links;
		$scope.edit.profile = response.user.user_profile;
		$scope.edit.cover = $scope.edit.profile.cover;
		$scope.edit.profile.born = new Date(+$scope.edit.profile.born*1000);
		$('.ui.accordion').accordion('refresh');
		//console.log(Date.parse('Aug 9, 1995'));
		//console.log($scope.memberProfile.member);
	});

	$scope.saveProfile = function(profile) {
		//profile.born = Date.parse(profile.born)/1000;
		$scope.isSaving = true;
		$http.put(kgConfig.api+$rootScope.auth.name+'/profile', profile).success(function(response) {
			UIkit.notify(response.message, response.status);
			$scope.isSaving = false;
		});
	}

	/*$scope.$on("cropme:done", function(ev, response, cropmeEl) {
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
	});*/
	/*$scope.savePict = function(filename) {
		$http.put(kgConfig.api+$rootScope.auth.name+'/pict', {
			user_pict : filename
		}).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.cropMeModal.hide();
			$scope.profile.edit.picture = filename;
		});
	};*/
	$scope.uploadPicture = function(isValid, file) {
        if (isValid) {
            $scope.onProgress1 = true;
            Upload.upload({
                url: kgConfig.api+$rootScope.auth.name+'/picture',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress1 = false;
                $scope.edit.picture = resp.data.picture;
            }, function (resp) {
				UIkit.notify(resp.data.message, resp.data.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress1 = progressPercentage;
            });
	    } else {
			UIkit.notify("Ukuran atau format file tidak sesuai", "error");
		}
    };
	$scope.uploadCover = function(isValid, file) {
        if (isValid) {
            $scope.onProgress2 = true;
            Upload.upload({
                url: kgConfig.api+$rootScope.auth.name+'/cover',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress2 = false;
                $scope.edit.cover = resp.data.cover;
            }, function (resp) {
				UIkit.notify(resp.data.message, resp.data.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress2 = progressPercentage;
            });
	    } else {
			UIkit.notify("Ukuran atau format file tidak sesuai", "error");
		}
    };
	$scope.addLink = function(link) {
		$scope.isAddLink = true;
		$http.post(kgConfig.api+$rootScope.auth.name+'/link', link)
		.success(function(response) {
			UIkit.notify(response.message, response.status);
			$scope.edit.user_link.push(response.link);
			$scope.isAddLink = false;
		})
	}
	$scope.removeLink = function(id) {
		if (confirm("Hapus link ini?")) {
			var index = $scope.indexSearch($scope.edit.user_link, id);
			$http.delete(kgConfig.api+$rootScope.auth.name+'/link/'+id)
			.success(function(response) {
				UIkit.notify(response.message, response.status);
				$scope.edit.user_link.splice(index, 1);
			})
		}
	}

	$scope.changeUser = function(field, input) {
		if (field == 'name') data = { name: input };
		else if (field == 'email') data = { email: input };
		else if (field == 'password') data = input;

		$http.put(kgConfig.api+$rootScope.auth.name+'/'+field, data).success(function(response) {
			UIkit.notify(response.data.success, response.status);
		}).catch(function (error){
			UIkit.notify(error.data.error, error.status);
		})
	}
}]
