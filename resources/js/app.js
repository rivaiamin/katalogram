var kgApp = angular.module('kgApp', ['ui.router', 'ngTagsInput', 'satellizer', 'cropme', 'angular-input-stars', 'ui.knob', 'ngTouch','superswipe','validation.match' ]);
var host = window.location.hostname;
kgApp
// route angular
.constant('kgConfig', {
	'site': '//'+host+'/',
	'api': '//api.'+host+'/',
	'files': '//files.'+host+'/',
	'embedly': '8081dea79e164014bcd7cd7e1ab2363a'
})
.config(['$stateProvider', '$httpProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', 'kgConfig', function($stateProvider, $httpProvider, $urlRouterProvider, $authProvider, $locationProvider, kgConfig) {
	$stateProvider.state('home', {
		url:'/', 
		templateUrl: 'catalogList.html',
		controller: 'catalogList'
	}).state('catalog', {
		url:'/catalog', 
		templateUrl: 'catalogList',
		controller: 'catalogList'
	}).state('catalogCategory', {
		url:'/catalog/category/:categoryId',
		templateUrl: 'catalogList.html',
		controller: 'catalogList'
	}).state('catalogDetail', {
		url:'/catalog/:productId', 
		templateUrl: 'catalogDetail.html',
		controller: 'catalogDetail'
	}).state('catalogEdit', {
		url:'/catalog/:productId/edit',
		templateUrl: 'editCatalog.html',
		controller: 'editCatalog'
	}).state('profile', {
		url:'/{username:[a-zA-Z1-9.-]*}', 
		templateUrl: 'memberProfile.html',
		controller: 'memberProfile'
	}).state('editProfile', {
		url:'/:username/edit',
		templateUrl: 'editMember.html',
		controller: 'editMember'
	});

	$locationProvider.html5Mode(true);
	$urlRouterProvider.otherwise('/catalog');
	$httpProvider.defaults.useXDomain = true;
	
	$authProvider.loginUrl = kgConfig.api+'member/login';
	$authProvider.signupUrl = kgConfig.api+'member/register';
	//embedlyServiceProvider.setKey('8081dea79e164014bcd7cd7e1ab2363a');

	$authProvider.facebook({
	  //for development
      //clientId: '1496399374007633', // for live
      clientId: '1496399374007633',
      url: kgConfig.api+'auth/facebook'
    });
 
    $authProvider.google({
      clientId:'13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com',
      url: kgConfig.api+'auth/google'
    });
}])

//main controller
.controller('kgController', ['$scope', '$rootScope', '$http', '$state', '$auth', '$sce', '$location', '$interval', 'kgConfig', function($scope, $rootScope, $http, $state, $auth, $sce, $location, $interval, kgConfig) {
	//init
	$rootScope.api = kgConfig.api;
	$rootScope.files = kgConfig.files;
	$scope.popup = function() {
		$('.browse').popup({ inline: true, hoverable: true,
			delay: {
				show: 300,
				hide: 800
			} });
	}
	$http.get(kgConfig.api+'category').success(function(response) {
		$rootScope.categories = response.categories;
		$scope.popup();
		//$scope.categories = $rootScope.categories;
	});
	$scope.modal = UIkit.modal("#kg-modal");
	$scope.feedback = {};

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
			$rootScope.user = response.user;
			$scope.popup();
		})
	};

	// member & authentication function
	$scope.authenticate = function(provider) {
		$auth.authenticate(provider)
		  .then(function(response) {
		  	$scope.getAuthUser();
		    $scope.modal.hide();
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
		$scope.modalTemplate = "loginMember.html";
    	$scope.modal.show();
    };
    $scope.loginMember = function(user) {
    	$auth.login(user)
		  .then(function(response) {
		    // Redirect user here after a successful log in.
		    //console.log(response.token)
		  	$scope.modal.hide();
		  	$scope.getAuthUser();
		  })
		  .catch(function(response) {
		    UIkit.notify(response.data.message, response.status);
		  });
    };
    $scope.registerPage = function() {
		$scope.modalTemplate = "registerMember.html";
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
	  		$scope.modal.hide();
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
            catalog = response.product[0];
            catalog.product_desc = $sce.trustAsHtml(catalog.product_desc);
            catalog.product_data = $sce.trustAsHtml(catalog.product_data);
            catalog.num_plus = Object.keys(catalog.feedback_plus).length;
            catalog.num_minus = Object.keys(catalog.feedback_minus).length;
            
            //return num_collect
            var num_collect = Object.keys(response.product[0].num_collect).length;
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
            catalog.avg_rate = Number((total_rate/num_criteria).toFixed(1));
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
            $scope.modalTemplate = "catalogDetail.html";

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
		$scope.modalTemplate = "createCatalog.html";
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
}])

.controller('catalogList',  ['$stateParams','$scope',  '$http', 'kgConfig', function($stateParams, $scope, $http, kgConfig) {
	$scope.catalog = {};
	var categoryId = $stateParams.categoryId;
	if (categoryId != null) var route = 'catalog/category/'+categoryId;
	else var route = 'catalog';
	$http.get(kgConfig.api+route)
	.success(function(response) {
		$scope.catalog.list = response.lists;
	});
}])
.controller('editCatalog',  ['$stateParams','$scope','$rootScope','$http','$sce','kgConfig', function($stateParams, $scope, $rootScope, $http, $sce,kgConfig) {
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
}])
.controller('memberProfile',  ['$state','$stateParams', '$scope', '$rootScope','$http', 'kgConfig', 
  function($state, $stateParams,$scope, $rootScope, $http, kgConfig) {
	$scope.cropMeModal = UIkit.modal("#cropMeModal");
	$http.get(
		//"json/member_profile.json"
		kgConfig.api+$stateParams.username
	).success(function(response) {
		$scope.profile = response;
		$scope.profile.member = response.user.member;
		$scope.profile.num_catalog = Object.keys(response.catalog).length;
		$scope.profile.num_collect = Object.keys(response.collect).length;
		$scope.profile.num_connect = Object.keys(response.connect).length;
		$scope.profile.num_contact = Object.keys(response.contact).length;
		$scope.profile.num_preview = Object.keys(response.preview).length;
		//console.log($scope.profile);
	}).catch(function(error) {
		//$state.go('home');
	});
	$scope.savePict = function(filename) {
		$http.put(kgConfig.api+$rootScope.user.name+'/pict', {
			user_pict : filename 
		}).success(function(response){
			UIkit.notify(response.message, response.status);
			$scope.cropMeModal.hide();
			$scope.profile.user.user_pict = filename;
		});
	};
	$scope.addConnect = function(userId) {
		$http.post(kgConfig.api+'connect/'+userId)
		.success(function(response) {
			UIkit.notify(response.data.message, response.status);
		})
	}
	$scope.removeConnect = function(userId) {
		$http.delete(kgConfig.api+'connect/'+userId)
		.success(function(response) {
			UIkit.notify(response.data.message, response.status);
		})
	}
	$scope.$on("cropme:done", function(ev, response, cropmeEl) {
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
	});

}])
.controller('editMember',  ['$stateParams','$scope', '$rootScope','$http', 'kgConfig', function($stateParams, $scope, $rootScope, $http, kgConfig) {
	$http({
		method: "GET",
		//url: "json/member_profile.json"
		url: kgConfig.api+$stateParams.username+'/edit',
	}).success(function(response) {
		$scope.profile = response;
		$scope.profile.member = response.user.member;
		$scope.profile.member.born = new Date(+$scope.profile.member.member_born*1000);
		$('.ui.accordion').accordion('refresh');
		//console.log(Date.parse('Aug 9, 1995'));
		//console.log($scope.memberProfile.member);
	});
	$scope.updateProfile = function(profile) {
		profile.member_born = Date.parse(profile.born)/1000;
		$http.put(kgConfig.api+$rootScope.user.name+'/profile', profile).success(function(response) {
			UIkit.notify(response.message, response.status);
		})
	}
	$scope.changeUser = function(field, input) {
		if (field == 'name') data = { name: input };
		else if (field == 'email') data = { email: input };
		else if (field == 'password') data = input;
		
		$http.put(kgConfig.api+$rootScope.user.name+'/'+field, data).success(function(response) {
			UIkit.notify(response.data.success, response.status);
		}).catch(function (error){
			UIkit.notify(error.data.error, error.status);
		}) 
	}
}])
.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
})
.directive('stopEvent', function () {
	return {
	  restrict: 'A',
	  link: function (scope, element, attr) {
	    element.on(attr.stopEvent, function (e) {
	      e.stopPropagation();
	    });
	  }
	};
})
.directive('kgUiDropdown', function () {
    return function (scope, element, attrs) {
		element.dropdown();
    };
})
.directive('kgPopup', function () {
    return function (scope, element) {
		element.popup({
			variation: 'inverted',
			position: 'bottom center'
		});
    };
})
.directive('kgTab', function () {
    return function (scope, element) {
		element.tab();
    };
});
/*.directive('kgEmbedly', ['$http', function($http) {
	return {
		template: '<blockquote class="embedly-card" data-card-key="{{ apikey }}" data-card-width="100%"><h4><a href="{{ embed.original_url }}"> {{ embed.title }}</a></h4><p>{{ embed.description }}</p></blockquote>',
		link: function(scope, element, attrs) {
			//url = encodeURI(scope.url);
			maxwidth = attrs.maxwidth;
			scope.apikey = attrs.apikey;
			attrs.$observe('url', function(value) {
				console.log(value);
				$http.get('http://api.embed.ly/1/extract?url='+value+'&maxwidth='+maxwidth+'&key='+scope.apikey)
				.success(function(response){
					scope.embed = response;
					$.getScript("//cdn.embedly.com/widgets/platform.js");
					//embedly('card', '.embedly-cardx');
					//console.log("embed="+value);
				})
			})
		}
	}
}])*/

(function(w, d){
   var id='embedly-platform', n = 'script';
   if (!d.getElementById(id)){
     w.embedly = w.embedly || function() {(w.embedly.q = w.embedly.q || []).push(arguments);};
     var e = d.createElement(n); e.id = id; e.async=1;
     e.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://cdn.embedly.com/widgets/platform.js';
     var s = d.getElementsByTagName(n)[0];
     s.parentNode.insertBefore(e, s);
   }
  })(window, document);
