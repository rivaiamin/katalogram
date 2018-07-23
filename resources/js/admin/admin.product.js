var productCtrl = ['$http','$scope', '$location', 'Notification','Upload',
    function($http, $scope, $location, Notification, Upload) {
	$.AdminLTE.layout.fix();

    $scope.onEdit = false;
    $scope.input = {};
    $scope.productAddForm = {};
    $scope.products = [];
    $scope.totalProducts = 0;
    $scope.limit = 20;
	$scope.after = 0;
	$scope.scrollBusy = false;
	$scope.scrollLast = false;

    /*$scope.listProduct = function() {
        $http.get($scope.env.api+'product')
        .success(function (response) {
            $scope.products = response.product;
        });
    };*/

    /*$scope.getResultsPage = function(page) {
        $http.get($scope.env.api+'product/paging/'+page+'/'+$scope.limit)
        .success(function (response) {
            $scope.products = response.products;
            $scope.totalProducts = response.count;
        });
    };

    $scope.pageChanged = function(page) {
        $scope.getResultsPage(page);
    };*/

	$scope.searchProduct = function(filter) {
		$scope.after = 0;
		$scope.products = [];
		$scope.nextPage();
		$scope.filter = filter;
	}

	$scope.nextPage = function() {
		$scope.scrollBusy = true;
		$http.get($scope.env.api+'product/scroll/'+$scope.after+'/'+$scope.limit, {
			params: $scope.filter
		}).success(function (response) {
			$scope.scrollBusy = false;
			for (var i = 0; i < response.catalogs.length; i++) {
				$scope.products.push(response.catalogs[i]);
			}
            //$scope.products.push(response.products[0]);
			if (response.catalogs.length > 0) {
				$scope.after = response.catalogs[response.catalogs.length - 1].id;
			} else {
				$scope.scrollLast = true;
			}
			//$('.ui.sticky').sticky('refresh');
			//console.log($scope.products);
        })
	}

	$scope.deleteProduct = function(id) {
		var index = $scope.indexSearch($scope.products, id);
		if (confirm('delete product?')) {
			$scope.onLoad = true;
			$http.delete($scope.env.api+'product/'+id)
			.success(function (response) {
				Notification({message: response.message}, response.status);
				if (response.status == 'success') {
					//console.log(response.type);
					$scope.products.splice(index, 1);
				}
				$scope.onLoad = false;
			});
		}
	};

    /*$scope.formProduct = function() {
        $http.get($scope.env.api+'product/form')
        .success(function (response) {
            $scope.productTypes = response.productTypes;
            $scope.cities = response.cities;
            $scope.provinces = response.provinces;
        });
    };

    $scope.uploadLogo = function(isValid, file) {
        if (isValid) {
            $scope.onProgress1 = true;
            Upload.upload({
                url: $scope.env.api+'product/logo',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress1 = false;
                $scope.input.logo = resp.data.logo;
            }, function (resp) {
                Notification({message: resp.message}, resp.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress1 = progressPercentage;
            });
	    }
    };

    $scope.uploadImage = function(isValid, file) {
        if (isValid) {
            $scope.onProgress2 = true;

            Upload.upload({
                url: $scope.env.api+'product/image',
                method: 'POST',
                data: {
                    image: file,
                }
            }).then(function (resp) {
                $scope.onProgress2 = false;
                $scope.input.image = resp.data.image;
            }, function (resp) {
                Notification({message: resp.message}, resp.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                $scope.progress2 = progressPercentage;
            });
	    }
    };

    $scope.resetProduct = function() {
        $scope.input = {};
        $("[data-widget='collapse']").click();
    };

	$scope.saveProduct = function(input) {
        $scope.onSave = true;
        if (input.id === undefined) {
            $http.post($scope.env.api+'product', input)
            .success(function (response) {
                Notification({message: response.message}, response.status);
                if (response.status == 'success') {
                    $scope.products.push(response.product[0]);
                    $scope.input.id = response.product[0].id;
                    //$scope.input = {};
                    //$scope.fileicon = {};
                    //$('#name').focus();
                }
				$scope.onSave = false;
            });
        } else {
            //input.city_id = $scope.input.city.id;
            //input.product_type_id = $scope.input.product_type.id;

            //var index = $scope.indexSearch($scope.products, input.id);

            $http.put($scope.env.api+'product/'+input.id, input)
            .success(function (response) {
                //$scope.products[index] = response.data.product[0];
                Notification({message: response.message}, response.status);
                //$scope.onEdit = false;
				$scope.onSave = false;
            });
        }
	};

    $scope.editProduct = function(id) {
        $scope.onEdit = false;
        $http.get($scope.env.api+'product/'+id)
        .success(function (response) {
            $scope.input = response.detail[0];
            $scope.input.product_type_id = parseInt($scope.input.product_type_id);
            $scope.input.province_id = parseInt($scope.input.city.province_id);
            $scope.input.city_id = parseInt($scope.input.city_id);

            $("[data-widget='collapse']").click();
            $location.hash('productForm');
        });
    };



	$scope.slug = function(npsn, str) {
        str = str.replace(/[^a-zA-Z0-9\s]/g,"");
        str = str.toLowerCase();
        str = str.replace(/\s/g,'-');
        return npsn+'-'+str;
    }
*/
    //$scope.listProduct();
    //$scope.getResultsPage(1);
    //$scope.formProduct();
}];
