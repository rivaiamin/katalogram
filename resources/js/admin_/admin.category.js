var categoryCtrl = ['$http','$scope', 'Upload', 'Notification', function($http, $scope, Upload, Notification) {
	$scope.currentPage = 1;
	$scope.limit = 10;

    $scope.listCategory = function() {
        $http.get($scope.env.api+'category')
        .success(function (response) {
            $scope.category = response.category;
        })
    }
    $scope.listCategory();

	$scope.addCategory = function(input) {
        if ($scope.categoryForm.fileimage.$valid && $scope.fileimage) {
		  $scope.onProgress = true;

	      Upload.upload({
	            url: $scope.env.api+'category/icon',
	            method: 'POST',
			    data: {
			    	image: $scope.fileimage,
			    }
			    /*sendFieldsAs: 'form',
			    fields: {
			        filename: $scope.file.name,
			        title: input.title
			    }*/
	        }).then(function (resp) {
	            $http.post($scope.env.api+'category', {
	            	category_name: input.name,
	            	category_desc: input.desc,
	            	category_icon: $scope.fileimage.name
	            })
				.success(function (response) {
					//UIkit.notify(response.message, response.status);
					if (response.status == 'success') {
						$scope.onProgress = false;
						$scope.category.push(response.category);
						Notification({message: response.message}, response.status);
						$scope.input = {};
						$scope.fileimage = {};
						$('#name').focus();
					}
				})
	        }, function (resp) {
                Notification({message: resp.message}, resp.status);
	        }, function (evt) {
	            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
	            $scope.progress = progressPercentage;
	        });
	    }
	}

	$scope.saveCategory = function(data, id) {
		return $http.put($scope.env.api+'category/'+id, data);
		/*.success(function (response) {
			UIkit.notify(response.message, response.status);
		})*/
	}
	$scope.deleteCategory = function(id) {
		var index = $scope.indexSearch($scope.category, id);
		if (confirm('delete category?')) {
			$http.delete($scope.env.api+'category/'+id)
			.success(function (response) {
                Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.category);
					$scope.category.splice(index, 1);
				}
			})
		}
	}
}];
