var catalogEditCtrl = ['$stateParams','$scope','$rootScope','$http','$sce','kgConfig',
  function($stateParams, $scope, $rootScope, $http, $sce,kgConfig) {
	$scope.modal1 = UIkit.modal("#cropmeModal");
	$scope.modal2 = UIkit.modal("#cropmeModal2");
	$scope.addPreview = false;
	$scope.preview = {};
	$http({
		method: "GET",
		//url: "json/edit_catalog.json"
		url: kgConfig.api+"catalog/"+$stateParams.productId+'/edit',
	}).success(function(response) {
		$scope.edit = response;
		$scope.edit.product = response.product[0];
		$scope.productId = $scope.edit.product.id;
		$scope.catInd = $scope.categories.map(function(el) {
		  return el.id;
		}).indexOf($scope.edit.product.category_id);
		//$scope.editCatalog.product = JSON.parse(response).edit_product[0];
		//$scope.editCatalog.product.product_desc = $sce.trustAsHtml(response.product[0].product_desc);
		//$scope.product_preview= response.product_preview;
		//$scope.product_criteria= response.product_criteria;
		//$scope.product_tag= response.product_tag;
		$scope.categories = $rootScope.categories;
		//UIkit.slider('#previewPict');
		$('.ui.checkbox').checkbox();
		$('.ui.accordion').accordion('refresh');
		$('.special.cards .image').dimmer({
		  on: 'hover'
		});
	});

	$scope.selectCats = function() {
		$scope.catInd = $("#categoryId").prop('selectedIndex') - 1;
	};
	$scope.saveLogo = function(filename, logo) {
		$http.put(
			kgConfig.api+"catalog/"+$scope.productId+'/logo', { product_logo: filename
			}
		).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.edit.product.product_logo = filename;
		});
	};
	$scope.savePreview = function(preview) {
		$http.post(
			kgConfig.api+"catalog/"+$scope.productId+'/preview',
			preview
		).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.addPreview = false;
			//TODO: gambar otomatis ditambahkan ke tampilan
		});
	};
	$scope.addCriteria = function(tag) {
		$http.post(
			kgConfig.api+"catalog/"+$scope.productId+'/criteria',
			tag
		).success(function(response){
			if (response.status == "success") return true;
			else return false;
			//TODO: id tag otomatis ditambahkan ke model
		});
	};
	$scope.removeCriteria = function(tag) {
		if (confirm("hapus kriteria?")) {
			$http.delete(
				kgConfig.api+"catalog/"+$scope.productId+'/criteria/'+tag.id
			).success(function(response){
				if (response.status == "success") return true;
			});
		} else {
			return false;
		}
	};
	$scope.addTag = function(tag) {
		$http.post(
			kgConfig.api+"catalog/"+$scope.productId+'/tag',
			tag
		).success(function(response){
			if (response.status == "success") return true;
			else return false;
		});
	};
	$scope.removeTag = function(tag) {
		if (confirm("hapus tag?")) {
			$http.delete(
				kgConfig.api+"catalog/"+$scope.productId+'/tag/'+tag.id
			).success(function(response){
				if (response.status == "success") return true;
			});
		} else {
			return false;
		}
	};
	$scope.updateCatalog = function(product, publish) {
		var input = {
			product_name: product.product_name,
			category_id: product.category_id,
			product_quote: product.product_quote,
			product_data: product.product_data,
			product_desc: product.product_desc,
			product_embed: product.product_embed
		};
		if (publish == 1) {
			if (!confirm("simpan dan publikasikan?")) return false;
			input.product_release = 1;
		}
		$http.put(kgConfig.api+"catalog/"+$scope.productId,
			input
		).success(function (response) {
            UIkit.notify(response.message, response.status);
	    });
    };

	$scope.$on("cropme:done", function(ev, response, cropmeEl) {
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

    });
}];
