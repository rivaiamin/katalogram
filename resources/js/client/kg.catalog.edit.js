var catalogEditCtrl = ['$stateParams','$scope','$rootScope','$http','$state','$sce','kgConfig', 'Upload',
  function($stateParams, $scope, $rootScope, $http, $state, $sce,kgConfig,Upload) {
	//$scope.modal1 = UIkit.modal("#cropmeModal");
	//$scope.modal2 = UIkit.modal("#cropmeModal2");
	/*$scope.addPreview = false;
	$scope.preview = {};*/
	$scope.product = {};
	$scope.isSaving = false;
	$rootScope.bgNav = 'kg-bg-base';

	$http({
		method: "GET",
		//url: "json/edit_catalog.json"
		url: kgConfig.api+"catalog/"+$stateParams.productId+'/edit',
	}).success(function(response) {
		if (response.product == null) $state.go('profile', { username: $rootScope.auth.name });
		$scope.product = response.product;
		$scope.productId = $scope.product.id;
		$scope.product.is_release = 1;
		/*$scope.catInd = $scope.categories.map(function(el) {
		  return el.id;
		}).indexOf($scope.product.category_id);
		$scope.editCatalog.product = JSON.parse(response).edit_product[0];
		$scope.editCatalog.product.product_desc = $sce.trustAsHtml(response.product[0].product_desc);
		$scope.product_preview= response.product_preview;*/
		var productCriteria = response.product.product_criteria;
		var productTag = response.product.product_tag;
		$scope.product.tag = [];
		$scope.product.criteria = [];
		for (i=0; i<productCriteria.length; i++) {
			$scope.product.criteria.push(productCriteria[i].criteria);
		};
		for (i=0; i<productTag.length; i++) {
			$scope.product.tag.push(productTag[i].tag);
		};
		//console.log($scope.tag);
		//$scope.categories = $rootScope.categories;
		//UIkit.slider('#previewPict');
		$('.ui.checkbox').checkbox();
		//$('.ui.accordion').accordion('refresh');
		$('.special.cards .image').dimmer({
		  on: 'hover'
		});
	});

	$scope.selectCats = function() {
		$scope.catInd = $("#categoryId").prop('selectedIndex') - 1;
	};
	$scope.uploadLogo = function(isValid, file) {
        if (isValid) {
            $scope.onProgress1 = true;
            Upload.upload({
                url: kgConfig.api+'catalog/'+$scope.productId+'/logo',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress1 = false;
                $scope.product.logo = resp.data.logo;
            }, function (resp) {
				UIkit.notify(resp.data.message, resp.data.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress1 = progressPercentage;
            });
	    }
    };
	$scope.uploadPicture = function(isValid, file) {
        if (isValid) {
            $scope.onProgress2 = true;
            Upload.upload({
                url: kgConfig.api+'catalog/'+$scope.productId+'/picture',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress2 = false;
                $scope.product.picture = resp.data.picture;
            }, function (resp) {
				UIkit.notify(resp.data.message, resp.data.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress2 = progressPercentage;
            });
	    }
    };

	$scope.loadTags = function($query) {
		return $http.get(kgConfig.api+'tag', { cache: true}).then(function(response) {
		  var tags = response.data;
		  return tags.filter(function(tag) {
			return tag.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
		  });
		});
	}
	$scope.loadCriterias = function($query) {
		return $http.get(kgConfig.api+'criteria', { cache: true}).then(function(response) {
		  var criterias = response.data;
		  return criterias.filter(function(criteria) {
			return criteria.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
		  });
		});
	}

	$scope.addCriteria = function(criteria) {
		$http.post(
			kgConfig.api+"catalog/"+$scope.productId+'/criteria',
			criteria
		).success(function(response){
			if (response.status == "success") return true;
			else return false;
			//TODO: id tag otomatis ditambahkan ke model
		});
	};
	$scope.removeCriteria = function(criteria) {
		if (confirm("hapus kriteria?")) {
			$http.delete(
				kgConfig.api+"catalog/"+$scope.productId+'/criteria/'+criteria.name
			).success(function(response){
				if (response.status == "success") return true;
				else return false;
			});
		} else {
			return false;
		}
	};

	$scope.addTag = function(tag) {
		//console.log(tag);
		$http.post(
			kgConfig.api+"catalog/"+$scope.productId+'/tag',
			tag
		).success(function(response){
			if (response.status == "success") {
				return true;
				/*if (response.tag) {
					$scope.product.tag.push(response.tag);
					$scope.product.tag.splice($scope.product.tag.length);
				}*/
			} else return false;
			//TODO: id tag otomatis ditambahkan ke model
		});
	};
	$scope.removeTag = function(tag) {
		if (confirm("hapus tag?")) {
			$http.delete(
				kgConfig.api+"catalog/"+$scope.productId+'/tag/'+tag.name
			).success(function(response){
				if (response.status == "success") return true;
				else return false;
			});
		} else {
			return false;
		}
	};

	$scope.toggleRelease = function() {
		if ($scope.product.is_release == 0) $scope.product.is_release = 1;
		else if ($scope.product.is_release == 1) $scope.product.is_release = 0;
		console.log($scope.product.is_release);
	}
	$scope.updateProduct = function(product, view) {
		$scope.isSaving = true;
		var publish = $('#is_release').prop('checked')?1:0;
		var input = {
			name: product.name,
			category_id: product.category_id,
			quote: product.quote,
			data: product.data,
			desc: product.desc,
			embed: product.embed,
			is_release: publish
		};
		$http.put(kgConfig.api+"catalog/"+$scope.productId,
			input
		).success(function (response) {
			$scope.isSaving = false;
			UIkit.notify(response.message, response.status);
			if (view == true) {
				$scope.catalogDetail($scope.productId);
			}
	    });
		//console.log($("#is_release").prop('checked'));
    };

	$scope.removeProduct = function() {
		if (confirm('hapus produk?')) {
			$http.delete(kgConfig.api+'catalog/'+$scope.productId)
			.success(function(response) {
            	UIkit.notify(response.message, response.status);
				$state.go('profile', { username: $rootScope.auth.name });
			});
		}
	}

	/*$scope.$on("cropme:done", function(ev, response, cropmeEl) {
        var blob = response.croppedImage;

        if (cropmeEl[0].id == 'cropme1') {
        	//$scope.image = blob;
	        $http({
				method: "POST",
				url: kgConfig.files+"saveimage.php",
				data: blob,
				headers: {
			        'Content-Type': blob.type
			    }
			}).success(function(response){
				if (response.status=='success') {
					$scope.saveLogo(response.filename, blob);
					$scope.modal1.hide();
				}
			})
        } else if (cropmeEl[0].id == 'cropme2') {
        	$http({
				method: "POST",
				url: kgConfig.files+"savepreview.php",
				data: blob,
				headers: {
			        'Content-Type': blob.type
			    }
			}).success(function(response){
				if (response.status=='success') {
					$scope.addPreview = true;
					$scope.preview.preview_pict = response.filename;
					$scope.modal2.hide();
				}
			})
        }

    });*/
}];
