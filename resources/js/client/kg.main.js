var kgCtrl = ['$scope', '$rootScope', '$http', '$state', '$auth', '$sce', '$location', '$interval', 'kgConfig',
  function($scope, $rootScope, $http, $state, $auth, $sce, $location, $interval, kgConfig) {
	//init
	$rootScope.api = kgConfig.api;
	$rootScope.files = kgConfig.files;
	$rootScope.modalTemplate1 = "";
	$scope.modalTemplate2 = "";
	$rootScope.modal1 = UIkit.modal("#kg-modal");
	$scope.modal2 = UIkit.modal("#kg-modal-lightbox");
	$scope.feedback = {};
	$scope.isSendFeedback = false;
	$scope.isCollecting = false;
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
	$scope.loadTags = function($query) {
		return $http.get(kgConfig.api+'tags', { cache: true}).then(function(response) {
		  var tags = response.data;
		  return tags.filter(function(tag) {
			return tag.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
		  });
		});
	}

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
		$scope.modalTemplate2 = "user.login.html";
    	$scope.modal2.show();
    };
    $scope.loginMember = function(user) {
		$scope.isLogging = true;
    	$auth.login(user)
		  .then(function(response) {
		    // Redirect user here after a successful log in.
		    //console.log(response.token)
		  	$scope.modal2.hide();
		  	$scope.getAuthUser();
			$scope.isLogging = false;
		  })
		  .catch(function(response) {
		    UIkit.notify('username atau password salah', 'error');
			$scope.isLogging = false;
		  });
    };
    $scope.registerPage = function() {
		$scope.modalTemplate2 = "user.register.html";
    	//$scope.modal.show();
    };
    $scope.registerMember = function(user) {
		$scope.isRegister = true;
		$auth.signup(user)
		  .then(function(response) {
		    // Redirect user here to login page or perhaps some other intermediate page
		    // that requires email address verification before any other part of the site
		    // can be accessed.
	  		$auth.setToken(response);
			$scope.isRegister = false;
	  		$scope.getAuthUser();
	  		$scope.modal2.hide();
		  })
		  .catch(function(response) {
		    // Handle errors here.
			$scope.isRegister = false;
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

	//catalog function
	$scope.createCatalog = function() {
		$rootScope.modalTemplate1 = "catalog.create.html";
		$scope.modal1.show();
	};
	$scope.saveCatalog = function(create) {
		$scope.isCreating = true;
		$http.post(kgConfig.api+"catalog", create
		).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.modal1.hide();
			$scope.isCreating = false;
			$state.go('catalogEdit', { productId: response.product_id });
		});
	};
	$rootScope.catalogDetail = function(productId) {
        $scope.loader = true;

		/*$http.get('http://api.page2images.com/restfullink', {
			p2i_url: kgConfig.api+'catalog/'+productId+'/view',
			p2i_device: '6',
			p2i_screen: '600x0',
			p2i_size: '600x0',
			p2i_fullpage: '1',
			p2i_imageformat: 'jpg',
			p2i_wait: '5',
			p2i_key: '1637af9a87b02321'
		}).then(function() {

		});*/

        $http.get(
			//url: "json/detail_catalog.json",
			kgConfig.api+"catalog/"+productId
		).success(function (response) {
            catalog = response.product;
            catalog.desc = $sce.trustAsHtml(catalog.desc);
            catalog.data = $sce.trustAsHtml(catalog.data);

			$rootScope.modalTemplate1 = "catalog.detail.html";
			$rootScope.modal1.show();
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
		    	barColor: '#FF8E1F'
		    }

            $scope.productId = catalog.id;
            $scope.catalog = catalog;

            //$scope.catalog_detail.product_data = $sce.trustAsHtml(response.product[0].product_data);

            //console.log($scope.product_rate);
            $scope.loader = false;
        });
    };

	$scope.searchCatalog = function(tags) {
		$rootScope.filter = [];
		$rootScope.filter.tags = [];
		for (var i=0; i<tags.length; i++) {
			$rootScope.filter.tags.push(tags[i].id);
		}
		//$state.go('catalog.search');
		$rootScope.$emit("searchCatalog", {});
	}

    $scope.embedPreview = function(url) {
    	var embed = '<a href="'+url+'" class="embedly-card preview-card">Embedly</a>';
    	$(".embed-preview").html(embed);
    	embedly('card', '.preview-card');
    };
	/*$scope.selectCategory = function(ind) {
		$scope.formCreate.category_id = $scope.categories[ind].category_id;
	}*/
	$scope.addCollect = function() {
		if ($scope.isCollecting == false) {
			$scope.isCollecting = true;
			$http.post(kgConfig.api+'collect/'+$scope.productId)
			.success(function(response) {
				UIkit.notify(response.message, response.status);
				if (response.status == 'success') $scope.catalog.collect_count++;
				$scope.catalog.is_collect = true;
				$scope.isCollecting = false;
			})
		}
	};
	$scope.removeCollect = function() {
		if ($scope.isCollecting == false) {
			$scope.isCollecting = true;
			$http.delete(kgConfig.api+'collect/'+$scope.productId)
			.success(function(response) {
				UIkit.notify(response.message, response.status);
				if (response.status == 'success') $scope.catalog.collect_count--;
				$scope.catalog.is_collect = false;
				$scope.isCollecting = false;
			})
		}
	};
	//rating
	$scope.giveRate = function(rating) {
		var input = {
			product_criteria_id: rating.id,
			value: rating.rate_avg
		};
		$http.post(kgConfig.api+'catalog/'+$scope.productId+"/rate", input
		).success(function(response) {
			UIkit.notify(response.message, response.status);
		});
	};
	//feedback
	$scope.sendFb = function(feedback) {
		$scope.isSendFeedback = true;
		$http.post(kgConfig.api+'catalog/'+$scope.productId+'/feedback',
			feedback
		).success(function(response) {
			UIkit.notify(response.message, response.status);
			if (response.status == 'success') {
				if ($scope.feedback.type == 'P') {
					$scope.catalog.feedback_plus.push(response.data);
					$scope.catalog.plus_count += 1;
				} else if ($scope.feedback.type == 'M') {
					$scope.catalog.feedback_minus.push(response.data);
					$scope.catalog.minus_count += 1;
				}
				$scope.feedback.type = '';
			}
			$scope.feedback.comment = '';
			$scope.isSendFeedback = false;
		})
	};
	$scope.rmFb = function(id, type) {
		if (confirm('hapus tanggapan ini?')) {
			if (type == 'P') item = $scope.catalog.feedback_plus;
			else if (type == 'M') item = $scope.catalog.feedback_minus;
			var index = $scope.indexSearch(item, id);

			$http.delete(kgConfig.api+'catalog/'+$scope.productId+'/feedback/'+id)
			.success(function(response) {
				UIkit.notify(response.message, response.status);
				if (response.status == 'success') {
					if (type== 'P') {
						$scope.catalog.feedback_plus.splice(index, 1);
						$scope.catalog.plus_count -= 1;
					} else if (type == 'M') {
						$scope.catalog.feedback_minus.splice(index, 1);
						$scope.catalog.minus_count -= 1;
					}
				}
			})
		}
	}
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
	    'hide.uk.modal': function(){
	        $rootScope.modalTemplate1 = "";
			$state.go('^');
	    }
	});
    $('#kg-modal-lightbox').on({
	    'show.uk.modal': function(){
	        $scope.blur = true;
	    },
	    'hide.uk.modal': function(){
	        $scope.$apply(function() {
	        	$scope.blur = false;
	        });
	        $scope.modalTemplate2 = "";
	    }
	});
    if (! $scope.isLogin()) {
    	//if (! $scope.refreshToken()) $scope.loginPage();
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
