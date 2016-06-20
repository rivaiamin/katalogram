var kgCtrl = ['$scope', '$rootScope', '$http', '$state', '$auth', '$sce', '$location', '$interval', 'kgConfig',
  function($scope, $rootScope, $http, $state, $auth, $sce, $location, $interval, kgConfig) {
	//init
	$rootScope.api = kgConfig.api;
	$rootScope.files = kgConfig.files;
	$scope.modalTemplate = "";
	$scope.modal = UIkit.modal("#kg-modal");
	$scope.modal2 = UIkit.modal("#kg-modal-lightbox");
	$scope.feedback = {};
	//$scope.bgNav = '';

	$scope.indexSearch = function(array, id) {
		return array.map(function(el) {
		  return el.id;
		}).indexOf(id);
    }

	$scope.popup = function() {
		$('.browse').popup({ inline: true, hoverable: true,
			delay: {
				show: 300,
				hide: 800
			} });
	}
	$http.get(kgConfig.api+'category').success(function(response) {
		$scope.categories = response.categories;
		$scope.popup();
		//$scope.categories = $rootScope.categories;
	});

	$scope.refreshToken = function() {
		$http.get(kgConfig.api+'auth/refresh')
		  .then(function(response) {
		    var refreshToken = response.headers('Authorization');
		    $auth.setToken(refreshToken);
		  })
		  .catch(function(error){
		  	return false;
		  });
	}

	$scope.getAuthUser = function() {
		$http.get(kgConfig.api+"auth/user")
		.success(function(response){
			$rootScope.auth = response.user;
			$scope.popup();
		})
	};

	// member & authentication function
	$scope.authenticate = function(provider) {
		$auth.authenticate(provider)
		  .then(function(response) {
		  	$scope.getAuthUser();
		    $scope.modal2.hide();
		  })
		  .catch(function(error) {
		  	//UIkit.notify(response.message);
		  	if (error.error) {
	            // Popup error - invalid redirect_uri, pressed cancel button, etc.
	            UIkit.notify(error.error);
	        } else if (error.data) {
	            // HTTP response error from server
	            UIkit.notify(error.data.message, error.status);
	        } else {
	            UIkit.notify(error);
	        }
		  });
	};

	$scope.loginPage = function() {
		$scope.modalTemplate = "user.login.html";
    	$scope.modal2.show();
    };
    $scope.loginMember = function(user) {
    	$auth.login(user)
		  .then(function(response) {
		    // Redirect user here after a successful log in.
		    //console.log(response.token)
		  	$scope.modal2.hide();
		  	$scope.getAuthUser();
		  })
		  .catch(function(response) {
		    UIkit.notify(response.data.message, response.status);
		  });
    };
    $scope.registerPage = function() {
		$scope.modalTemplate = "user.register.html";
    	$scope.modal.show();
    };
    $scope.registerMember = function(user) {
		$auth.signup(user)
		  .then(function(response) {
		    // Redirect user here to login page or perhaps some other intermediate page
		    // that requires email address verification before any other part of the site
		    // can be accessed.
	  		$auth.setToken(response);
	  		$scope.getAuthUser();
	  		$scope.modal2.hide();
		  })
		  .catch(function(response) {
		    // Handle errors here.
		    UIkit.notify(response.data.message, response.status);
		  });
    };
    //cek status login
    $scope.isLogin = function() {
    	return $auth.isAuthenticated();
    };
    // menghapus sesi user
    $scope.logout = function() {
    	$auth.logout();
    	$scope.loginPage();
    	//console.log("logout");
    };

    // catalog function
    $scope.catalogDetail = function(productId) {
        $scope.loader = true;
        $http.get(
			//url: "json/detail_catalog.json",
			kgConfig.api+"catalog/"+productId
		).success(function (response) {
            var detail = response;
            catalog = response.product;
            catalog.desc = $sce.trustAsHtml(catalog.desc);
            catalog.data = $sce.trustAsHtml(catalog.data);

			$scope.modalTemplate = "catalog.detail.html";
			$scope.modal.show();
            //return num_collect
            /*var num_collect = Object.keys(response.product[0].num_collect).length;
            if (num_collect ==0) catalog.num_collect = 0;
            else catalog.num_collect = catalog.num_collect[0].numCollect;

            //return avg_rate
            var total_rate=0, num_criteria=0, criteria = catalog.criteria;
            for (var i=0; i<criteria.length; i++) {
            	if (criteria[i].avg_criteria.length != 0) {
            		total_rate += parseFloat(criteria[i].avg_criteria[0].criteria_rate);
            	}
            	num_criteria++;
            }
            catalog.avg_rate = Number((total_rate/num_criteria).toFixed(1));*/
            //console.log(catalog.avg_rate);

            //knob
            $scope.knob = {};
            $scope.knob.options = {
		    	readOnly: true,
		    	max: 5,
		    	trackWidth: 40,
		    	barWidth: 30,
		    	trackColor: '#eee',
		    	barColor: '#0079ab'
		    }

            $scope.productId = catalog.id;
            $scope.catalog = catalog;

            //$scope.catalog_detail.product_data = $sce.trustAsHtml(response.product[0].product_data);

            //console.log($scope.product_rate);
            $scope.loader = false;
        });
    };

    $scope.embedPreview = function(url) {
    	var embed = '<a href="'+url+'" class="embedly-card preview-card">Embedly</a>';
    	$(".embed-preview").html(embed);
    	embedly('card', '.preview-card');
    };
    $scope.createCatalog = function() {
		$scope.modalTemplate = "catalog.create.html";
		$scope.modal.show();
	};
	/*$scope.selectCategory = function(ind) {
		$scope.formCreate.category_id = $scope.categories[ind].category_id;
	}*/
	$scope.saveCatalog = function(create) {
		$http.post(kgConfig.api+"catalog", create
		).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.modal.hide();
			$state.go('catalogEdit', { productId: response.product_id });
		});
	};

	$scope.addCollect = function() {
		$http.post(kgConfig.api+'catalog/'+$scope.productId+'/collect')
			.success(function(response) {
				UIkit.notify(response.message, response.status);
				if (response.status == 'success') $scope.productDetail.num_collect++;
			})
	};

	//rating
	$scope.giveRate = function(rating) {
		var input = {
			criteria_id: rating.id,
			rate_value: rating.avg_criteria[0].criteria_rate
		};
		$http.post(kgConfig.api+'catalog/'+$scope.productId+"/rate", input
		).success(function(response) {
			UIkit.notify(response.message, response.status);
		});
	};

	//feedback
	$scope.sendFb = function(feedback) {
		$http.post(kgConfig.api+'catalog/'+$scope.productId+'/feedback',
			feedback
		).success(function(response) {
			UIkit.notify(response.message, response.status);
			if (response.status == 'success') {
				if ($scope.feedback.feedback_type == 'P') {
					$scope.catalog.feedback_plus.push(response.data);
					$scope.catalog.numPlus += 1;
				} else if ($scope.feedback.feedback_type == 'N') {
					$scope.catalog.feedback_minus.push(response.data);
					$scope.catalog.numMinus += 1;
				}
				$scope.feedback.feedback_type = '';
			}
			$scope.feedback.feedback_comment = '';
		})
	};

	$scope.respondFb = function(index, feedback_id, type) {
		$http.post(kgConfig.api+'feedback/'+feedback_id+'/respond/'+type)
			.success(function(response){
				UIkit.notify(response.message, response.status);
				if (response.status == 'success') productDetail.feedback_minus[index].plus_respond++;
			})
	};

    // utility function
    $scope.setBlur = function(status) {
    	$scope.blur = status;
    };
    $scope.navbarSubToggle = function(content) {
		if ($scope.navbarSubShow == false) $scope.navbarSubShow = true;
		else $scope.navbarSubShow = false;
		$scope.navbarSub = content;
	};

	$scope.closeModal = function() {
		$scope.modal.hide();
	}
    $('#kg-modal').on({
	    'show.uk.modal': function(){
	        $scope.blur = true;
	    },
	    'hide.uk.modal': function(){
	        $scope.$apply(function() {
	        	$scope.blur = false;
	        });
	        $scope.modalTemplate = "";
	    }
	});

    if (! $scope.isLogin()) {
    	if (! $scope.refreshToken()) $scope.loginPage();
    } else {
    	$scope.getAuthUser();
    }
	//console.log($rootScope.user);
	/*$scope.imgCrop = function(inputFile) {


	    var handleFileSelect=function(evt) {
	        var file=evt.currentTarget.files[0];
	        $scope.$apply(function($scope){
	             $scope.myImage = URL.createObjectURL(file);
	         });
	    };
	    angular.element(document.querySelector(inputFile)).on('change',handleFileSelect);
	}*/
}];
